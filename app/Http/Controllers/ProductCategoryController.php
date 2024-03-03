<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class ProductCategoryController extends Controller
{
    /**
     * 카테고리 목록을 조회합니다.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(): Response
    {
        $categories = Category::all();
        return response()->json($categories);
    }

    /**
     * 새 카테고리 생성
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request): Response
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);

        $category = Category::create($validated);
        return response()->json($category, 201);
    }

    /**
     * 특정 카테고리 조회
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id): Response
    {
        $category = Category::findOrFail($id);
        return response()->json($category);
    }

    /**
     * 특정 카테고리 업데이트
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Category $category): Response
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);

        $category->update($validated);
        return response()->json($category);
    }

    /**
     * 지정 카테고리 삭제
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Category $category): Response
    {
        $category->delete();
        return response()->json(['message' => '카테고리를 삭제했습니다']);
    }
}
