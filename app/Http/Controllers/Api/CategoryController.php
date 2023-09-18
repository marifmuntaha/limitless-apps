<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreCategoryRequest;
use App\Http\Requests\UpdateCategoryRequest;
use App\Http\Resources\CategoryResource;
use App\Models\Category;
use Exception;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $category = new Category();
        return response([
            'message' => null,
            'result' => CategoryResource::collection($category->get())
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreCategoryRequest $request)
    {
        $this->authorize('create', Category::class);
        try {
            return ($category = Category::create($request->all())) ?
                response([
                    'message' => 'Data Kategori berhasil disimpan.',
                    'result' => $category
                ]) : throw new Exception('Terjadi kesalahan server');
        } catch (Exception $exception) {
            return response([
                'message' => $exception->getMessage(),
                'result' => null
            ], 422);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Category $category)
    {
        return response([
            'message' => null,
            'result' => new CategoryResource($category)
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateCategoryRequest $request, Category $category)
    {
        $this->authorize('update', $category);
        try {
            return $category->update(array_filter($request->all())) ?
                response([
                    'message' => 'Data Kategori berhasil disimpan.',
                    'result' => $category
                ]) : throw new Exception('Terjadi kesalahan server');
        } catch (Exception $exception) {
            return response([
                'message' => $exception->getMessage(),
                'result' => null
            ], 422);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Category $category)
    {
        try {
            return $category->delete() ?
                response([
                    'message' => 'Data Kategori berhasil dihapus.',
                    'result' => $category
                ]) : throw new Exception('Terjadi kesalahan server');
        }
        catch (Exception $exception) {
            return response([
                'message' => $exception->getMessage(),
                'result' => null
            ], 422);
        }
    }
}
