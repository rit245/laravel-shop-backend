<?php

use App\Http\Controllers\CartController;
use App\Http\Controllers\OrderController;
use App\Livewire\HomeComponent;
use App\Livewire\OrderFormComponent;
use App\Livewire\ProductDetailComponent;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

//Route::get('/', function () {
//    return view('home');
//});


// cart, order 라우터
Route::resource('carts', CartController::class);
Route::resource('orders', OrderController::class);


// cart 블레이드
Route::get('/cart', function () {
    return view('cart');
});

// order 블레이드
Route::get('/order', function () {
    return view('order');
});


Route::get('/', HomeComponent::class);
Route::get('/product/{productId}', ProductDetailComponent::class);
Route::get('/order/{productId}', OrderFormComponent::class);
