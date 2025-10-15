<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use App\Models\Products;
use App\Models\Orders;

class OrderController extends Controller
{
    public function order_check()
    {
        return self::returnView('menu.order');
    }

    public function order_product($id)
    {
        $product = Products::where('id', $id)->first();
        if ($product) {
            return self::returnView('menu.order-product')->with('product', $product);
        }
        return back();
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
        }

        return redirect()->route('menu.type', ['type' => Str::slug($data['product-type'])]);
    }
}
