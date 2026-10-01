<?php

namespace App\Http\Controllers\Auth;

use App\Exceptions\AuthException;
use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Http\Requests\Auth\RegisterRequest;
use App\Http\Resources\Auth\AuthResource;
use App\Services\UserService;
use Exception;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    public function __construct(protected UserService $userService)
    {}

    public function register(RegisterRequest $request)
    {
            $validasi = $request->validated();
            $data = $this->userService->registerUser($validasi);

            return response()->json([
                'status' => 'success',
                'data' => new AuthResource($data),
            ], 201);
        
    }

    public function login(LoginRequest $request)
    {
            $validasi = $request->validated();
            $data = $this->userService->loginUser($validasi);

            return response()->json([
                'status' => 'success',
                'data' => new AuthResource($data)
            ], 201);
    }

    public function logout()
    {
            $this->userService->logoutUser();

            return response()->json([
                'status' => 'success',
                'message' => 'berhasil logout'
            ], 201);
    }
}