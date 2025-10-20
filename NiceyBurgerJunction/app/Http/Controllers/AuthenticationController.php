<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Orders;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

class AuthenticationController extends Controller
{
    public function login(Request $request)
    {
        $guest_id = (Auth::check()) ? Auth::id() : null;
        
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required|string',
        ]);

        if (Auth::attempt($credentials)) {
            if ($guest_id) {
                Orders::turnoverPendingOrders($guest_id);
            } else {
                Orders::removePendingOrders();
            }
            User::where('id', Auth::id())
                ->update(['branch_id' => (session('branch_id')) ? session('branch_id') : null]);
            session(['branch_id' => null]);
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
            'branch_id' => (session('branch_id')) ? session('branch_id') : null,
        ]);

        Auth::login($user);

        session(['branch_id' => null]);
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
            'user_type' => 'Member',
            'branch_id' => (session('branch_id')) ? session('branch_id') : null,
        ]);

        Auth::login($user);

        if ($guest_id) {
            Orders::turnoverPendingOrders($guest_id);
        } else {
            Orders::removePendingOrders();
        }
        session(['branch_id' => null]);
        $request->session()->regenerate();
        return redirect()->route('index');
    }

    public function forgot_pass_email(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
        ]);

        $email = $request['email'];
        $user = User::where('email', $email)->first();

        if ($user) {

            do {
                $code = strtoupper(Str::random(5));
                $hashed_code = Hash::make($code);
            } while (User::where('pass_code', $hashed_code)->first());

            Mail::raw('Your code to change your password is '.$code.'.', function ($message) use ($email) {
                $message->to($email)
                        ->subject('Change Password');
            });

            User::where('id', $user->id)
                ->update([
                    'pass_code' => $hashed_code,
                    'pass_code_exp_date' => now()->addMinutes(30),
                ]);

            session()->flash('id', $user->id);
            return redirect()->route('forgot-password.code.show');
        }
        return back()->withErrors(['email' => 'Email address was not found.']);
    }

    public function forgot_pass_code(Request $request)
    {
        if (session('id')) {

            session()->reflash();
            $user = User::where('id', session('id'))->first();

            if ($user && now()->greaterThan($user['pass_code_exp_date'])) {
                User::where('id', session('id'))
                    ->update([
                        'pass_code' => null,
                        'pass_code_exp_date' => null,
                    ]);
                session()->forget('id');
                return redirect()->route('forgot-password.email.show');
            }

            if ($user && Hash::check($request['code'], $user['pass_code'])) {
                User::where('id', session('id'))
                    ->update([
                        'pass_code' => null,
                        'pass_code_exp_date' => null,
                    ]);
                return redirect()->route('forgot-password.change.show');
            } else {
                return back()->withErrors(['email' => 'Invalid Code']);
            }
        }
        session()->forget('id');
        abort(404);
    }

    public function forgot_pass_change(Request $request)
    {
        session()->reflash();

        $request->validate([
            'password' => 'required|string|min:6|confirmed'
        ]);

        if (session('id')) {
            User::where('id', session('id'))
                ->update([
                    'password' => Hash::make($request['password']),
                ]);
            
            $user = User::where('id', session('id'))->first();

            session()->forget('id');
            Auth::login($user);
            session(['branch_id' => null]);
            $request->session()->regenerate();
            return redirect()->intended(route('index'));
        }
        session()->forget('id');
        return abort(404);
    }

    public function logout(Request $request)
    {
        User::where(['id' => Auth::id()])->update(['branch_id' => null]);
        Orders::removePendingOrders();
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('index');
    }
}
