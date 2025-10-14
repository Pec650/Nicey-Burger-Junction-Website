<?php

namespace App\Http\Controllers;

use App\Models\Admins;
use Illuminate\Http\Request;

class PageController extends Controller
{
    public function home() {
        return view('home.home');
    }

    public function about() {
        return view('home.about');
    }

    public function menu() {
        return view('home.menu');
    }

    public function career() {
        return view('home.career');
    }

    // TODO: UPDATE THIS LATER
    public function login() {
        return view('auth.login');
    }

    public function register() {
        return view('auth.register');
    }

    public function forgetPassword() {
        return view('home');
    }
}
