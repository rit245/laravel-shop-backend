<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Cart;

class CartController extends Controller
{
    // 장바구니 목록 조회
    public function index()
    {
        $carts = Cart::all();
        return view('cart', compact('carts'));
    }

    // 장바구니 상품 추가 폼
    public function create()
    {
        return view('carts.create');
    }

    // 장바구니 상품 추가 처리
    public function store(Request $request)
    {
        Cart::create($request->all());
        return redirect()->route('cart');
    }

    // 장바구니 상품 상세 조회
    public function show($id)
    {
        $cart = Cart::findOrFail($id);
        return view('carts.show', compact('cart'));
    }

    // 장바구니 상품 수정 폼
    public function edit($id)
    {
        $cart = Cart::findOrFail($id);
        return view('cart', compact('cart'));
    }

    // 장바구니 상품 수정 처리
    public function update(Request $request, $id)
    {
        $cart = Cart::findOrFail($id);
        $cart->update($request->all());
        return redirect()->route('cart');
    }

    // 장바구니 상품 삭제 처리
    public function destroy($id)
    {
        $cart = Cart::findOrFail($id);
        $cart->delete();
        return redirect()->route('cart');
    }
}
