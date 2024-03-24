<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;

class OrderController extends Controller
{
    // 주문 목록 조회
    public function index(Request $request)
    {
        $productId = $request->query('productId');

        return view('order', compact('productId'));
    }

    // 주문 폼
    public function create()
    {
        return view('orders.create');
    }

    // 주문 처리
    public function store(Request $request)
    {
        Order::create($request->all());
        return redirect()->route('orders.index');
    }

    // 주문 상세 조회
    public function show($id)
    {
        $order = Order::findOrFail($id);
        return view('orders.show', compact('order'));
    }

    // 주문 수정 폼
    public function edit($id)
    {
        $order = Order::findOrFail($id);
        return view('orders.edit', compact('order'));
    }

    // 주문 수정 처리
    public function update(Request $request, $id)
    {
        $order = Order::findOrFail($id);
        $order->update($request->all());
        return redirect()->route('orders.index');
    }

    // 주문 삭제 처리
    public function destroy($id)
    {
        $order = Order::findOrFail($id);
        $order->delete();
        return redirect()->route('orders.index');
    }
}
