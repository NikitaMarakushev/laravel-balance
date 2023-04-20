<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\UserBalanceController;
use App\Http\Controllers\UserBalanceOperationsController;
use App\Http\Controllers\UserBalanceOperationsHistoryController;
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
    return redirect('/home');
});

Auth::routes();

Route::get('/home', [HomeController::class, 'index'])->name('home');
Route::post('/operations_last', [HomeController::class, 'getOperations'])->name('refresh_data_operations');
Route::get('/operations_history', [UserBalanceOperationsController::class, 'index'])->name('operations_history');
Route::post('/balance/change', [UserBalanceController::class, 'updateBalance'])->name('update_balance');
