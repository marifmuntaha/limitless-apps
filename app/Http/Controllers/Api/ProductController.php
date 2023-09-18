<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreProductRequest;
use App\Http\Requests\UpdateProductRequest;
use App\Http\Resources\ProductResource;
use App\Models\Product;
use Exception;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return response([
            'message' => null,
            'result' => ProductResource::collection(Product::all())
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreProductRequest $request)
    {
        $this->authorize('create', Product::class);
        try {
            return ($product = Product::create($request->all())) ? response([
                'message' => 'Data produk berhasil disimpan.',
                'result' => $product
            ], 201) : throw new Exception('Terjadi kesalahan di Server.');
        }
        catch (Exception $exception){
            return response([
                'message' => $exception->getMessage(),
                'result' => null
            ], 422);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Product $product)
    {
        return response([
            'message' => null,
            'result' => new ProductResource($product)
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateProductRequest $request, Product $product)
    {
        $this->authorize('update', $product);
        try {
            if ($product->update($request->all())){
                return response([
                    'message' => 'Data Produk berhasil diperbarui.',
                    'result' => $product
                ]);
            }
            else {
                throw new Exception('Terjadi kesalahan server');
            }
        }
        catch (Exception $exception){
            return response([
                'message' => $exception->getMessage(),
                'result' => null
            ], 422);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Product $product)
    {
        $this->authorize('delete',$product);
        try {
            if ($product->delete()){
                return response([
                    'message' => 'Data produk berhasil dihapus.',
                    'result' => $product
                ]);
            }
            else {
                throw new Exception('Terjadi kesalahan server.');
            }
        }
        catch (Exception $exception){
            return response([
                'message' => $exception->getMessage(),
                'result' => null
            ]);
        }
    }
}
