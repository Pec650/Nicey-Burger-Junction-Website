<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PageController extends Controller
{

    public function home() {
        return self::returnView('home.home');
    }

    public function about() {
        return self::returnView('home.about');
    }

    public function career() {
        return self::returnView('home.career');
    }

    public function login() {
        return self::returnView('auth.login');
    }

    public function guest() {
        return self::returnView('auth.guest_login');
    }

    public function register() {
        return self::returnView('auth.register');
    }

    public function forgetPassword() {
        return self::returnView('home');
    }
}
