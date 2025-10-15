<?php

use App\Http\Controllers\AuthenticationController as AuthControllers;
use App\Http\Controllers\MenuController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\OrderController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

Route::get('/', function(){ return redirect()->route('home'); })->name('index');

/* MAIN PAGES */
Route::get('/home', [PageController::class, 'home'])->name('home');
Route::get('/about', [PageController::class, 'about'])->name('about');
Route::get('/career', [PageController::class, 'career'])->name('career');
/******************************************************************************************/

/* MENU PAGES */
Route::get('/menu', function() { return redirect()->route('menu.type', ['type' => 'buy-1-take-1']); })->name('menu');
Route::get('/menu/{type}', [MenuController::class, 'menu'])->name('menu.type');
Route::get('menu/product/productID={id}', function() { return redirect()->route('menu.type', ['type' => 'buy-1-take-1']); });
Route::post('menu/product/productID={id}', [OrderController::class, 'order_product'])->name('menu.product');
/******************************************************************************************/

/* ORDER PAGES */
Route::get('/orders', [OrderController::class, 'order_check'])->name('order.check');
Route::post('/create-order', [OrderController::class, 'create_order'])->name('order.create');
/******************************************************************************************/

/* AUTHENTICATION PAGES */
Route::get('/login', [PageController::class, 'login'])->name('login.show');
Route::post('/login', [AuthControllers::class, 'login'])->name('login');
Route::get('/guest', [PageController::class, 'guest'])->name('guest.show');
Route::post('/guest', [AuthControllers::class, 'guest'])->name('guest.login');
Route::get('/register', [PageController::class, 'register'])->name('register.show');
Route::post('/register', [AuthControllers::class, 'register'])->name('register');
Route::post('/logout', [AuthControllers::class, 'logout'])->name('logout');
/******************************************************************************************/