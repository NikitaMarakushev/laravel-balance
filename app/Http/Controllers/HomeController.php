<?php

namespace App\Http\Controllers;

use App\Models\UserBalance;
use App\Models\UserBalanceOperations;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return Renderable
     */
    public function index()
    {
        $userId = Auth::user()->id;
        $userName = Auth::user()->name;
        $userBalance = UserBalance::query()
            ->select('value', 'id')
            ->where('user_id', $userId)
            ->get()
            ->first();

        $userBalanceValue = $userBalance->value;

        $operations = UserBalanceOperations::query()
            ->where('user_balance_id', $userBalance->id)
            ->orderBy('id', 'desc')
            ->cursorPaginate(5);

        return view('home', [
            'current_user' => $userName,
            'user_balance' => $userBalanceValue,
            'operations' => $operations,
        ]);
    }
}
