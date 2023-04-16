<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;

class UserBalanceOperationsController extends Controller
{
    public function index(): JsonResponse
    {
        $jsonData = [
            'status' => 'SUCCESS',
        ];

        return response()->json($jsonData);
    }
}
