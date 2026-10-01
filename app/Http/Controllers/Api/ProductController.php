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
    public function __construct(protected ProductService $productService)
    {}

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = $this->productService->getAllCategory();

        return response()->json([
            'status' => 'success',
            'data' => ProductResource::collection($data)
        ], 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreRequest $request)
    {
        $validasi = $request->validated();
        $data = $this->productService->createCategory($validasi);

        return response()->json([
            'status' => 'success',
            'data' => new ProductResource($data)
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $data = $this->productService->getByIdCategory($id);

        return response()->json([
            'status' => 'success',
            'data' => new ProductResource($data)
        ], 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateRequest $request, string $id)
    {
        $validasi = $request->validated();
        $data = $this->productService->updateCategory($id, $validasi);

        return response()->json([
            'status' => 'success',
            'data' => new ProductResource($data)
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $data = $this->productService->getByIdCategory($id);
        $this->productService->delete($id);

        return response()->json([
            'status' => 'success',
            'message' => "menghapus product ({$data['name']})"
        ], 200);
    }
}
