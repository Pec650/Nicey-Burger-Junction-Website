<?php

use App\Http\Controllers\AuthenticationController as AuthControllers;
use App\Http\Controllers\MenuController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\OrderController;
use App\Models\Orders;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

Route::get('/', function(){ return redirect()->route('home'); })->name('index');

/* MAIN PAGES */
Route::get('/home', [PageController::class, 'home'])->name('home');
Route::get('/about', [PageController::class, 'about'])->name('about');
Route::get('/career', [PageController::class, 'career'])->name('career');
/******************************************************************************************/

/* MENU PAGES */
Route::get('/menu/branch', [MenuController::class, 'branch'])->name('menu.branch');
Route::post('/menu/branch/id={id}', [MenuController::class, 'set_branch'])->name('menu.set_branch');
Route::post('/menu/reset_branch', [MenuController::class, 'reset_branch'])->name('menu.reset_branch');
Route::get('/menu', function() { return redirect()->route('menu.type', ['type' => 'buy-1-take-1']); })->name('menu');
Route::get('/menu/{type}', [MenuController::class, 'menu'])->name('menu.type');
Route::get('/menu/product/product_id={id}', [OrderController::class, 'order_product_show'])->name('menu.product.show');
Route::post('/menu/product/product_id={id}', [OrderController::class, 'order_product'])->name('menu.product');
/******************************************************************************************/

/* ORDER PAGES */
Route::get('/orders', [OrderController::class, 'order_check'])->name('order.check');
Route::post('/orders/create', [OrderController::class, 'create_order'])->name('order.create');
Route::get('/orders/edit/order_id={id}', [OrderController::class, 'edit_order_show'])->name('order.edit.show');
Route::post('/orders/edit/order_id={id}', [OrderController::class, 'edit_order'])->name('order.edit');
Route::post('/orders/update', [OrderController::class, 'update_order'])->name('order.update');
Route::get('/orders/delete/order_id={id}', function() { return abort(404); });
Route::post('/orders/delete/order_id={id}', [OrderController::class, 'delete_order'])->name('order.delete');
Route::post('/orders/empty', [OrderController::class, 'empty_order'])->name('order.empty');
/******************************************************************************************/

/* PLACED ORDER PAGES */
Route::post('/orders/placed', [OrderController::class, 'place_order'])->name('order.place');
Route::get('/orders/placed', [OrderController::class, 'ongoing_order'])->name('order.ongoing');
Route::get('/orders/placed/map', [OrderController::class, 'order_map'])->name('order.map');
Route::get('/orders/placed/list', [OrderController::class, 'order_list'])->name('order.list');
Route::post('/orders/placed/list/view/product_id={id}', [OrderController::class, 'order_view'])->name('order.view');
Route::get('/orders/view/order_id={id}', [OrderController::class, 'order_view_show'])->name('order.view.show');
Route::post('/orders/cancel', [OrderController::class, 'cancel_order'])->name('order.cancel');
Route::post('orders/complete/order_id={id}', [OrderController::class, 'complete_order'])->name('order.complete');
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