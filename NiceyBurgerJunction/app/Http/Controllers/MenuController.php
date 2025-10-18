<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Models\User;
use App\Models\Products;
use App\Models\Address;
use App\Models\Orders;
use Illuminate\Support\Facades\Auth;

class MenuController extends Controller
{
    public function address()
    {
        $address = Address::all();
        return self::returnView('home.address-select')->with('addresses', $address);
    }

    public function set_address($id) {
        if (Auth::check()) {
            User::where(['id' => Auth::id()])->update(['address_id' => $id]);
            Orders::removePendingOrders();
        } else {
            session(['address_id' => $id]);
        }
        return redirect()->route('menu');
    }

    public function reset_address()
    {
        if (Auth::check()) {
            User::where(['id' => Auth::id()])->update(['address_id' => null]);
            Orders::removePendingOrders();
        } else {
            session(['address_id' => null]);
        }
        return redirect()->route('menu');
    }

    public function menu($type)
    {
        if (Auth::check() && Auth::user()->address_id == null) {
            return redirect()->route('menu.address');
        }
        if (!Auth::check() && !session('address_id')) {
            return redirect()->route('menu.address');
        }

        $address_id = (Auth::check()) ? Auth::user()->address_id : session('address_id');
        $address = Address::where('id', $address_id)->first();

        $type = Str::title(str_replace('-', ' ', $type));
        $products = Products::where('type', $type)->get();
        if ($products->count() > 0) {
            return self::returnView('home.menu')
                ->with('type', $type)
                ->with('products', $products)
                ->with('address', $address);
        }
        return redirect()->route('menu');
    }
}
