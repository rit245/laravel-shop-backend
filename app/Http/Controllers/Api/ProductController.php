<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class ProductController extends Controller
{
    /**
     * 상품 목록 조회ddd
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $products = Product::all();
        return response()->json($products);
    }

    /**
     * 상품 정보 조회
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $product = Product::find($id);

        if (!$product) {
            return response()->json(['message' => '상품이 존재하지 않습니다'], 404);
        }

        return response()->json($product);
    }

    /**
     * 상품 생성
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     *
     */
    public function store(Request $request): Response
    {
        // 유효성 검사
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'required|numeric',
            'category_id' => 'required|integer|exists:categories,id', // 카테고리가 존재하는지 확인
        ]);

        // 상품 생성
        $product = Product::create($validated);

        // 생성된 상품 반환
        return response()->json($product, 201);
    }
}
