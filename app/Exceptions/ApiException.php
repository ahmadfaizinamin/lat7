<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Validation\ValidationException;

class ApiException extends Exception
{
    public function render(Exception $exception, string $message = 'Server terjadi error'): JsonResponse
    {
        if ($exception instanceof ValidationException) {
            return response()->json([
                'status' => 'error',
                'message' => 'data tidak valid',
                'error' => $exception->errors()
            ], 422);
        } else if ($exception instanceof ModelNotFoundException) {
            return response()->json([
                'status' => 'error',
                'message' => 'data tidak ditemukan'
            ], 404);
        }

        return response()->json([
            'status' => 'error',
            'message' => $message,
            'error' => $exception->getMessage()
        ], 500);
    }
}
