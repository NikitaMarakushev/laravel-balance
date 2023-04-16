<?php

use App\Http\Controllers\Api\V1\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});


/** @TODO Реализовать rest api для пользователя, баланса, операций */
Route::get('users/v1/list', [UserController::class, 'list'])->name('user.v1.list');
Route::get('users/v1/get{user}', [UserController::class, 'getUser'])->name('user.v1.get');
