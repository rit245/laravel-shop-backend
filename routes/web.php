<?php

use App\Http\Controllers\CartController;
use App\Http\Controllers\OrderController;
use App\Livewire\CartComponent;
use App\Livewire\HomeComponent;
use App\Livewire\OrderFormComponent;
use App\Livewire\ProductDetail;
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

Route::get('/order/{productId}', OrderFormComponent::class);
Route::get('/product/{productId}', ProductDetail::class)->name('product.detail');

Route::get('/cart', CartComponent::class)->name('cart');
Route::get('/order-complete', function () {
    return view('order-complete');
})->name('order-complete');

// 주문 목록 조회
Route::get('/order', [OrderController::class, 'index'])->name('order.index');
