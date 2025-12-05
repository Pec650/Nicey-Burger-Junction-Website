<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Models\User;
use App\Models\Products;
use App\Models\Branch;
use App\Models\Orders;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class MenuController extends Controller
{
    public function branch(Request $request)
    {
        if (Auth::check() && Auth::user()->branch_id != null) {
            return redirect()->route('menu');
        }
        if (!Auth::check() && session('branch_id')) {
            return redirect()->route('menu');
        }

        if ($request->input('search')) {
            $search = $request->input('search');

            $branch = Branch::where('branch_name', 'like', "%{$search}%")
                            ->orWhere('barangay', 'like', "%{$search}%")
                            ->orWhere('city', 'like', "%{$search}%")
                            ->get();
        } else {
            $branch = Branch::all();
        }

        return self::returnView('home.branch')->with('branches', $branch);
    }

    public function set_branch($id) {
        if (Auth::check()) {
            User::where(['id' => Auth::id()])->update(['branch_id' => $id]);
            Orders::removePendingOrders();
        } else {
            session(['branch_id' => $id]);
        }
        return redirect()->route('menu');
    }

    public function reset_branch()
    {
        if (Auth::check()) {
            User::where(['id' => Auth::id()])->update(['branch_id' => null]);
            Orders::removePendingOrders();
        } else {
            session(['branch_id' => null]);
        }
        return redirect()->route('menu');
    }

    public function menu($type)
    {
        // ... (Keep your Auth checks here) ...
        if (Auth::check() && Auth::user()->branch_id == null) {
            return redirect()->route('menu.branch');
        }
        if (!Auth::check() && !session('branch_id')) {
            return redirect()->route('menu.branch');
        }

        $branch_id = (Auth::check()) ? Auth::user()->branch_id : session('branch_id');
        $branch = Branch::where('id', $branch_id)->first();

        $type = Str::title(str_replace('-', ' ', $type));
        $products = Products::where('type', $type)
                    ->where('branch_id', $branch_id)
                    ->where('quantity', '!=', 0)
                    ->get();
        
        $unavailableProducts = Products::where('type', $type)
                                ->where('branch_id', $branch_id)
                                ->where('quantity', '==', 0)
                                ->get();

        // FIX: Always return the view, even if products count is 0.
        // Let the blade file handle the "empty" state.
        return self::returnView('home.menu')
                ->with('type', $type)
                ->with('products', $products)
                ->with('unavailable', $unavailableProducts)
                ->with('branch', $branch);
    }
}
