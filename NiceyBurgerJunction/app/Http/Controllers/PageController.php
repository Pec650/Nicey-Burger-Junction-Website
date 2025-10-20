<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PageController extends Controller
{

    public function home() 
    {
        return self::returnView('home.home');
    }

    public function about() 
    {
        return self::returnView('home.about');
    }

    public function career() 
    {
        return self::returnView('home.career');
    }

    public function login() 
    {
        return self::returnView('auth.login');
    }

    public function guest() 
    {
        return self::returnView('auth.guest_login');
    }

    public function register() 
    {
        return self::returnView('auth.register');
    }

    public function forgot_pass_email() 
    {
        return self::returnView('forgot-password.email');
    }

    public function forgot_pass_code() 
    {
        if (session('id')) {
            session()->reflash();
            return self::returnView('forgot-password.code');
        }
        return abort(404);
    }

    public function forgot_pass_change()
    {
        if (session('id')) {
            session()->reflash();
            return self::returnView('forgot-password.change-password');
        }
        return abort(404);
    }
}
