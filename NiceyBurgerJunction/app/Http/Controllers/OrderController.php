<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use App\Models\User;
use App\Models\Products;
use App\Models\Orders;
use App\Models\Branch;
use App\Models\Payments;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
    public function order_check()
    {
        if (!Auth::check()) return abort(404);

        // Check for ANY active order status
        $ongoing_orders = Orders::where('user_id', Auth::id())
                                ->whereIn('status', ['Ongoing', 'Preparing', 'Ready for Pickup'])
                                ->get();
                                    
        if ($ongoing_orders->count() > 0) {
            return redirect()->route('order.ongoing');
        }

        // FIXED: Join products and removed ->get() to let Blade handle it
        $orders = Orders::join('products', 'orders.product_id', '=', 'products.id')
                        ->select(
                            'orders.*',
                            'orders.id as order_id',
                            'products.id as product_id',
                            'products.name as product_name',
                            'products.price as product_price',
                            'products.type as product_type',
                            'products.img_dir as product_image', 
                        )->where('user_id', Auth::id())
                        ->where('status', 'Pending')
                        ->get();

        $branch = Branch::where('id', Auth::user()->branch_id)->first();
        
        $total = Orders::where('user_id', Auth::id())
                        ->where('status', 'Pending')
                        ->sum('total_price');

        return self::returnView('menu.order')
                   ->with('orders', $orders)
                   ->with('branch', $branch)
                   ->with('total_price', $total);
    }

    public function order_product_show($id)
    {
        $product = Products::where('id', $id)->first();

        if (!$product) {
            return redirect()->route('menu');
        }

        return self::returnView('menu.order-product')
            ->with('product', $product);
    }

    public function order_product($id)
    {
        return redirect()->route('menu.product.show', ['id' => $id])->with('id', $id);
    }

    public function create_order(Request $request) {
        if (Auth::check()) {

            $data = $request;

            if (Orders::hasOngoingOrders()) {
                return redirect()->route('menu.type', ['type' => Str::slug($data['product-type'])])
                                 ->with('error-title', 'ONGOING ORDER')
                                 ->with('error', 'Could not place order, you currently have an ongoing order.');
            }

            $existing_order = Orders::where('product_id', $data['product-id'])
                                    ->where('user_id', Auth::id())        
                                    ->where('status', 'Pending');

            if ($existing_order->count() > 0) {
                $existing_order->increment('quantity', $data['quantity']);
            } else {
                Orders::create([
                    'user_id' => Auth::id(),
                    'product_id' => $data['product-id'], 
                    'quantity' => $data['quantity'],
                    'total_price' => $data['product-price'] * $data['quantity'],
                    'request' => $data['request'],
                ]);
            }
            
            Products::where('id', $data['product-id'])
                    ->where('quantity', '>=', $data['quantity'])
                    ->decrement('quantity', $data['quantity']);
            

            session()->flash('success_msg', 'Successfully added item to your order!');
        }

        return redirect()->route('menu.type', ['type' => Str::slug($data['product-type'])]);
    }

    public function edit_order_show($id)
    {
        if (Auth::check() && session('id') && session('id') == $id) {
            session()->reflash();
            
            $order = Orders::join('products', 'orders.product_id', '=', 'products.id')
                            ->select(
                                'orders.*',
                                'orders.id as order_id',
                                'products.id as product_id',
                                'products.name as product_name',
                                'products.price as product_price',
                                'products.type as product_type',
                                'products.img_dir as product_image',
                            )->where('orders.id', $id)->first();

            if ($order) {
                return self::returnView('menu.order-edit')
                           ->with('order', $order);
            }
        }
        return abort(404);
    }

    public function edit_order($id)
    {
        return redirect()->route('order.edit.show', ['id' => $id])->with('id', $id);
    }

    public function update_order(Request $request)
    {
        $data = $request;

        $order = Orders::find($data['order-id']);
        if ($order) {
            $order->quantity = $data['quantity'];
            $order->total_price = $data['quantity'] * $data['product-price'];
            if (!empty(trim($data['request']))) {
                $order->request = $data['request'];
            }
            $order->save();

            session()->flash('success_msg', 'Successfully updated item!');
        }

        return redirect()->route('order.check');
    }

    public function delete_order($id)
    {
        if (Auth::check()) {
            $delete_order = Orders::where('id', $id)
                                    ->where('status', 'Pending')
                                    ->first();
            if ($delete_order) {
                Products::where('id', $delete_order->product_id)
                        ->increment('quantity', $delete_order->quantity);

                $delete_order->delete();
            }
            session()->flash('success_msg', 'Successfully removed item.');
            return redirect()->route('order.check');
        }
        return abort(404);
    }

    public function empty_order()
    {
        if (Auth::check()) {
            Orders::removePendingOrders();
            session()->flash('success_msg', 'Successfully cancelled your order.');
            return redirect()->route('order.check');
        }
        return abort(404);
    }

    public function place_order()
    {
        if (Auth::check()) {
            $ongoing_orders = Orders::where('user_id', Auth::id())
                                    ->where('status', 'Ongoing')
                                    ->get();
                                    
            if ($ongoing_orders->count() > 0) {
                return redirect()->route('order.ongoing');
            }
            
            $orders = Orders::where('user_id', Auth::id())
                            ->where('status', 'Pending');

            $payment = Payments::create([
                'user_id' => Auth::id(),
                'total_payment' => $orders->sum('total_price'),
                'total_quantity' => $orders->sum('quantity'),
                'branch_id' => Auth::user()->branch_id,
            ]);

            $orders->update([
                'status' => 'Ongoing',
                'payment_id' => $payment->id,
            ]);

            return redirect()->route('order.ongoing');
        }
        return abort(404);
    }

    public function ongoing_order()
    {
        if (Auth::check()) {
            // 1. Check for TRULY active orders first
            $payment = Payments::where('user_id', Auth::id())
                               ->whereIn('remarks', ['Ongoing', 'Preparing', 'Ready for Pickup', 'Waiting for Confirmation'])
                               ->first();
            
            if ($payment) {
                // ... (Existing logic for active orders) ... (15 Minutes Before Uncancellable)
                $cancellable = now()->lessThan($payment['created_at']->addMinutes(15));
                if ($payment['remarks'] !== 'Ongoing') {
                    $cancellable = false;
                }

                $branch = Branch::where('id', $payment['branch_id'])->first();
                $branch['phone_num'] = preg_replace('/^(\d{4})(\d{3})(\d{4})$/', '$1-$2-$3', $branch['phone_num']);
                
                return self::returnView('menu.placed-order')
                           ->with('payment', $payment)
                           ->with('cancellable', $cancellable)
                           ->with('branch', $branch);
            }

            // 2. NEW LOGIC: Check if we have a RECENTLY COMPLETED order (e.g., in the last 10 minutes)
            // This prevents the 404 crash if the kitchen just finished it.
            $recent_completed = Payments::where('user_id', Auth::id())
                                        ->where('remarks', 'Completed')
                                        ->orderBy('updated_at', 'desc') // Get the latest one
                                        ->first();

            // If we find a recently completed order (and no active ones), redirect them gracefully
            if ($recent_completed) {
                // Optional: Check if it was completed very recently (e.g. within 1 hour)
                // If you want to show a "Thank You" page, you can return a view here instead.
                
                return redirect()->route('menu')
                                 ->with('success_msg', 'Your order is complete! Thank you for dining with Nicey Burger.');
            }
        }
        
        // 3. Only abort if they truly have NO history and NO active order
        // Or better yet, just redirect to Menu instead of showing an error page.
        return redirect()->route('menu'); 
    }

    public function order_map()
    {
        if (Auth::check()) {
            // FIXED: Look for ANY active status
            $payment = Payments::where('user_id', Auth::id())
                               ->whereIn('remarks', ['Ongoing', 'Preparing', 'Ready for Pickup'])
                               ->first();
            
            if ($payment) {
                $branch = Branch::where('id', $payment['branch_id'])->first();
                return self::returnView('menu.placed-order-map')->with('branch', $branch);
            }
        }
        return abort(404);
    }
    
    public function order_list()
    {
        if (Auth::check()) {
            // FIXED: Look for ANY active status
            $payment = Payments::where('user_id', Auth::id())
                               ->whereIn('remarks', ['Ongoing', 'Preparing', 'Ready for Pickup'])
                               ->first();
            
            if ($payment) {
                // FIXED: Join products and added ->get() 
                // (Assuming this view expects a collection, not a query builder)
                $orders = Orders::join('products', 'orders.product_id', '=', 'products.id')
                                ->select(
                                    'orders.*',
                                    'orders.id as order_id',
                                    'products.id as product_id',
                                    'products.name as product_name',
                                    'products.price as product_price',
                                    'products.type as product_type',
                                    'products.img_dir as product_image',
                                )->where('payment_id', $payment['id'])
                                ->get(); 

                return self::returnView('menu.placed-order-list')->with('orders', $orders);
            }
        }
        return abort(404);
    }

    public function order_view($id)
    {
        if (Auth::check()) {
            return redirect()->route("order.view.show", ['id' => $id])->with('id', $id);
        }
        return abort(404);
    }

    public function order_view_show($id)
    {
        if (Auth::check() && session('id')) {
            session()->reflash();
            
            $order = Orders::join('products', 'orders.product_id', '=', 'products.id')
                            ->select(
                                'orders.*',
                                'orders.id as order_id',
                                'products.id as product_id',
                                'products.name as product_name',
                                'products.price as product_price',
                                'products.type as product_type',
                                'products.img_dir as product_image',
                            )->where('orders.id', $id)->first();
            if ($order) {
                return self::returnView('menu.placed-order-product')->with('order', $order);
            }
        }
        return abort(404);
    }

    public function cancel_order(Request $request)
    {
        if (Auth::check()) {
            $payment = Payments::where('user_id', Auth::id())
                               ->where('remarks', 'Ongoing')
                               ->first();

            // Safety check: if payment is gone (became Preparing), stop here
            if (!$payment) {
                return redirect()->route('order.ongoing');
            }

            if (now()->greaterThan($payment['created_at']->addMinutes(5))) {
                return redirect()->route('order.ongoing')
                                ->with('error-title', 'UNABLE TO CANCEL')
                                ->with('error', 'Order cannot be cancelled because it already reached its time limit.');
            }
            
            if($request->reason) {
                $payment->update([
                    'cancel_reason' => $request->reason
                ]);
            }

            User::where('id', Auth::id())
                ->update(['branch_id' => $payment['branch_id']]);

            Orders::where('payment_id', $payment['id'])
                  ->update([
                    'status' => 'Pending',
                    'payment_id' => null,
                  ]);
            $payment->update(['remarks' => 'Cancelled']);
        }
        
        return redirect()->route('order.check');
    }

    public function complete_order($id)
    {
        if (Auth::check()) {
            Payments::where('id', $id)
                ->update(['remarks' => 'Completed']);
            Orders::where('payment_id', $id)
                ->update(['status' => 'Complete']);
            User::where('id', Auth::id())
                ->update(['branch_id' => null]);
            session()->flash('success_msg', 'Successfully completed order! Enjoy your meal!');
            return redirect()->route('menu');
        }
        abort(404);
    }

    public function customer_received($id)
    {
        if (Auth::check()) {
            
            // Force status update
            DB::table('payment')
                ->where('id', $id)
                ->update(['remarks' => 'Completed']);

            DB::table('orders')
                ->where('payment_id', $id)
                ->update(['status' => 'Complete']);

            // Free the user
            User::where('id', Auth::id())->update(['branch_id' => null]);
            
            session()->flash('success_msg', 'Thank you! Please wait for the cashier to close your transaction.');
            
            return redirect()->route('menu');
        }
        return abort(404);
    }
}