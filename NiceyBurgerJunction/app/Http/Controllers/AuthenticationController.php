<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Orders;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class AuthenticationController extends Controller
{
    public function login(Request $request)
    {
        $guest_id = (Auth::check()) ? Auth::id() : null;
        
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required|string',
        ]);

        $credentials['address_id'] = null;

        if (Auth::attempt($credentials)) {
            if ($guest_id) {
                Orders::turnoverPendingOrders($guest_id);
            } else {
                Orders::removePendingOrders();
            }
            $request->session()->regenerate();
            return redirect()->intended(route('index'));
        }

        return back()->withErrors(['email' => 'Incorrect email address or password.']);
    }

    public function guest(Request $request)
    {
        $user = User::create([
            'name' => $request['name'],
            'email' => null,
            'password' => null,
            'user_type' => 'Guest',
            'address_id' => (session('address_id')) ? session('address_id') : null,
        ]);

        Auth::login($user);

        $request->session()->regenerate();
        return redirect()->intended(route('menu'));
    }

    public function register(Request $request)
    {
        $guest_id = (Auth::check()) ? Auth::id() : null;

        $data = $request->validate([
            'username' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:6|confirmed'
        ]);

        $user = User::create([
            'name' => $data['username'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
            'user_type' => 'Member'
        ]);

        Auth::login($user);

        if ($guest_id) {
            Orders::turnoverPendingOrders($guest_id);
        } else {
            Orders::removePendingOrders();
        }

        return redirect()->route('index');
    }

    public function logout(Request $request)
    {
        User::where(['id' => Auth::id()])->update(['address_id' => null]);
        Orders::removePendingOrders();
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('index');
    }
}
