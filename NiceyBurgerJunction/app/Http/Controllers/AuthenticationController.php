<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class AuthenticationController extends Controller
{
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required|string',
        ]);

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            return redirect()->intended(route('index'));
        }

        return back()->withErrors(['email' => 'Incorrect email address or password.']);
    }

    public function guest(Request $request)
    {
        $credentials = $request->validate([
            'name' => 'required|string',
        ]);
        $credentials['user_type'] = 'Guest';

        if (!Auth::attempt($credentials)) {
            $user = User::create([
                'name' => $credentials['name'],
                'email' => null,
                'password' => null,
                'user_type' => 'Guest'
            ]);
            
            Auth::login($user);
        }

        $request->session()->regenerate();
        return redirect()->intended(route('menu'));
    }

    public function register(Request $request)
    {
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

        return redirect()->route('index');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('index');
    }
}
