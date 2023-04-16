<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;

class UserController extends Controller
{
    public function index(): JsonResponse
    {
        $jsonData = [
            'status' => 'SUCCESS',
        ];

        return response()->json($jsonData);
    }

    public function getUser(string $user): JsonResponse
    {
        $jsonData = [
            'status' => 'SUCCESS',
            'user' => $user,
        ];

        return response()->json($jsonData);
    }
}
