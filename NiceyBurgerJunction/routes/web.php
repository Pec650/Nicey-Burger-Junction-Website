<?php

use App\Http\Controllers\AuthenticationController as AuthControllers;
use App\Http\Controllers\PageController;
use Illuminate\Support\Facades\Route;

Route::get('/', function(){ return redirect()->route('home'); })->name('index');

/* MAIN PAGES */
Route::get('/home', [PageController::class, 'home'])->name('home');
Route::get('/about', [PageController::class, 'about'])->name('about');
Route::get('/menu', [PageController::class, 'menu'])->name('menu');
Route::get('/career', [PageController::class, 'career'])->name('career');

/* AUTHENTICATION PAGES */
Route::get('/login', [PageController::class, 'login'])->name('login.show');
Route::post('/login', [AuthControllers::class, 'login'])->name('login');
Route::get('/register', [PageController::class, 'register'])->name('register.show');
Route::post('/register', [AuthControllers::class, 'register'])->name('register');
Route::post('/logout', [AuthControllers::class, 'logout'])->name('logout');