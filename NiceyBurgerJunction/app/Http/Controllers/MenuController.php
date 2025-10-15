<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Models\Products;

class MenuController extends Controller
{
    public function menu($type)
    {
        $type = Str::title(str_replace('-', ' ', $type));
        $products = Products::where('type', $type)->get();
        if ($products->count() == 0) {
            return redirect()->route('menu');
        }
        return self::returnView('home.menu')
        ->with('type', $type)
        ->with('products', Products::where('type', $type)->get());
    }
}
