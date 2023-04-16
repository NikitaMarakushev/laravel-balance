<?php

use App\Http\Controllers\Api\V1\UserController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

/** @TODO Реализовать rest api для пользователя, баланса, операций */
Route::get('users/v1/list', [UserController::class, 'list'])->name('user.v1.list');
Route::get('users/v1/get{user}', [UserController::class, 'getUser'])->name('user.v1.get');


Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

