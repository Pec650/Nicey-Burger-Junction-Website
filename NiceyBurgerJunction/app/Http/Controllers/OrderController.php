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

class OrderController extends Controller
{
    public function order_check()
    {
        if (!Auth::check()) return abort(404);

        $ongoing_orders = Orders::where('user_id', Auth::id())
                                ->where('status', 'Ongoing')
                                ->get();
                                    
        if ($ongoing_orders->count() > 0) {
            return redirect()->route('order.ongoing');
        }

        $orders = Orders::join('products', 'product_id', '=', 'products.id')
                        ->select(
                            'orders.*',
                            'orders.id as order_id',
                            'products.id as product_id',
                            'products.name as product_name',
                            'products.price as product_price',
                            'products.type as product_type',
                            'products.img_dir as product_image',
                        )->where('user_id', Auth::id())
                        ->where('status', 'Pending');
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
        if (session('id') && session('id') == $id) {
            session()->reflash();
            $product = Products::where('id', $id)->first();
            if ($product) {
                return self::returnView('menu.order-product')->with('product', $product);
            }
        }
        return abort(404);
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
                                 ->with('error', 'Could place order, you currently have ongoing order.');
            }

            $existing_order = Orders::where('product_id', $data['product-id'])
                                    ->where('user_id', Auth::id())        
                                    ->where('status', 'Pending');

            if ($existing_order->count() > 0) {
                // UPDATE EXISTING ORDER WITH STATUS 'PENDING'
                $existing_order->increment('quantity', $data['quantity']);
            } else {
                // CREATE A NEW ORDER
                Orders::create([
                    'user_id' => Auth::id(),
                    'product_id' => $data['product-id'],
                    'quantity' => $data['quantity'],
                    'total_price' => $data['product-price'] * $data['quantity'],
                    'request' => $data['request'],
                ]);
            }

            session()->flash('success_msg', 'Successfully added item to your order!');
        }

        return redirect()->route('menu.type', ['type' => Str::slug($data['product-type'])]);
    }

    public function edit_order_show($id)
    {
        if (Auth::check() && session('id') && session('id') == $id) {
            session()->reflash();
            $order = Orders::join('products', 'product_id', '=', 'products.id')
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
            Orders::where('id', $id)
                  ->where('status', 'Pending')
                  ->delete();
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
            $payment = Payments::where('user_id', Auth::id())
                               ->where('remarks', 'Ongoing')
                               ->first();
            
            if ($payment) {
                $branch = Branch::where('id', $payment['branch_id'])->first();
                $branch['phone_num'] = preg_replace('/^(\d{4})(\d{3})(\d{4})$/', '$1-$2-$3', $branch['phone_num']);
                return self::returnView('menu.placed-order')
                           ->with('payment', $payment)
                           ->with('branch', $branch);
            }
        }
        return abort(404);
    }

    public function order_map()
    {
        if (Auth::check()) {
            $payment = Payments::where('user_id', Auth::id())
                               ->where('remarks', 'Ongoing')
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
            $payment = Payments::where('user_id', Auth::id())
                               ->where('remarks', 'Ongoing')
                               ->first();
            
            if ($payment) {
                $orders = Orders::join('products', 'product_id', '=', 'products.id')
                                ->select(
                                    'orders.*',
                                    'orders.id as order_id',
                                    'products.id as product_id',
                                    'products.name as product_name',
                                    'products.price as product_price',
                                    'products.type as product_type',
                                    'products.img_dir as product_image',
                                )->where('payment_id', $payment['id']);
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
            $order = Orders::join('products', 'product_id', '=', 'products.id')
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

    public function cancel_order()
    {
        if (Auth::check()) {
            $payment = Payments::where('user_id', Auth::id())
                               ->where('remarks', 'Ongoing')
                               ->first();
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
}
