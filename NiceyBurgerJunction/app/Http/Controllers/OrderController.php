<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use App\Models\Products;
use App\Models\Orders;
use App\Models\Address;

class OrderController extends Controller
{
    public function order_check()
    {
        if (!Auth::check()) return abort(404);

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
        $address = Address::where('id', Auth::user()->address_id)->first();
        $total = Orders::where('user_id', Auth::id())
                        ->where('status', 'Pending')
                        ->sum('total_price');
        return self::returnView('menu.order')
                ->with('orders', $orders)
                ->with('address', $address)
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
}
