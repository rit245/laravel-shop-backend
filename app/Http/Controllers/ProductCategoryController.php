<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Models\ProductCategory;
use Illuminate\Http\JsonResponse;

class ProductCategoryController extends Controller
{
    /**
     * 카테고리 목록 조회
     *
     * 클라이언트가 요청한 페이지에 따라 카테고리 목록을 페이지네이션하여 반환
     * perPage 파라미터를 통해 페이지당 표시할 항목 수를 지정 가능 (기본값 20)
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function index(Request $request): JsonResponse
    {
        // 페이지당 항목 수에 대한 유효성 검사 규칙을 적용 (sometimes 를 사용하면 필드가 입력 배열에 존재할 때만 유효성 검사)
        $validated = $request->validate([
            'perPage' => 'sometimes|required|integer|min:1',
        ]);

        // perPage 파라미터 없는 경우 기본값 20
        $perPage = $validated['perPage'] ?? 20;

        $categories = ProductCategory::paginate($perPage);
        return response()->json($categories);
    }

    /**
     * 새 카테고리 생성
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function store(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);

        $category = ProductCategory::create($validated);
        return response()->json($category, 201);
    }

    /**
     * 특정 카테고리 조회
     *
     * @param int $id
     * @return JsonResponse
     */
    public function show($id): JsonResponse
    {
        $category = ProductCategory::findOrFail($id);
        return response()->json($category);
    }

    /**
     * 특정 카테고리 업데이트
     *
     * @param Request $request
     * @param ProductCategory $category
     * @return JsonResponse
     */
    public function update(Request $request, ProductCategory $category): JsonResponse
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
     * @param ProductCategory $category
     * @return JsonResponse
     */
    public function destroy(ProductCategory $category): JsonResponse
    {

        //validate the request
        $validated = $category->validate([
            'id' => 'required|integer|exists:product_categories,id'
        ]);

        $category->delete($validated);
        return response()->json(['message' => '카테고리를 삭제했습니다']);
    }
}
