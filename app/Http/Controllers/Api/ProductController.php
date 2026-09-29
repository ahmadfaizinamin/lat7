<?php

namespace App\Http\Controllers\Api;

use App\Exceptions\ApiException;
use App\Http\Controllers\Controller;
use App\Http\Requests\Product\StoreRequest;
use App\Http\Requests\Product\UpdateRequest;
use App\Http\Resources\ProductResource;
use App\Services\ProductService;
use Exception;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    protected ProductService $productService;
    protected ApiException $exception;

    public function __construct(ProductService $productService, ApiException $excetion)
    {
        $this->productService = $productService;
        $this->exception = $excetion;
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {
            $data = $this->productService->getAllCategory();

            return response()->json([
                'status' => 'success',
                'data' => ProductResource::collection($data)
            ], 200);
        } catch (Exception $e) {
            return $this->exception->render($e, 'gagal mengambil product');
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreRequest $request)
    {
        try {
            $validasi = $request->validated();
            $data = $this->productService->createCategory($validasi);

            return response()->json([
                'status' => 'success',
                'data' => new ProductResource($data)
            ], 201);
        } catch (Exception $e) {
            return $this->exception->render($e, 'gagal membuat product');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        try {
            $data = $this->productService->getByIdCategory($id);

            return response()->json([
                'status' => 'success',
                'data' => new ProductResource($data)
            ], 200);
        } catch (Exception $e) {
            return $this->exception->render($e, 'gagal mengambil product');
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateRequest $request, string $id)
    {
        try {
            $validasi = $request->validated();
            $data = $this->productService->updateCategory($id, $validasi);

            return response()->json([
                'status' => 'success',
                'data' => new ProductResource($data)
            ], 200);
        } catch (Exception $e) {
            return $this->exception->render($e, 'gagal update product');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            $data = $this->productService->getByIdCategory($id);
            $this->productService->delete($id);

            return response()->json([
                'status' => 'success',
                'message' => "menghapus product ({$data['name']})"
            ], 200);
        } catch (Exception $e) {
            return $this->exception->render($e, 'gagal hapus product');
        }
    }
}
