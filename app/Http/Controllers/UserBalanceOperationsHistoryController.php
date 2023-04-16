<?php

namespace App\Http\Controllers;

use App\Models\UserBalance;
use App\Models\UserBalanceOperations;
use Illuminate\Support\Facades\Auth;

class UserBalanceOperationsHistoryController extends Controller
{
    public const MAX_PER_PAGE_OPERATIONS_HISTORY = 15;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

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
            ->cursorPaginate(self::MAX_PER_PAGE_OPERATIONS_HISTORY);

        return view('operations_history', [
            'current_user' => $userName,
            'user_balance' => $userBalanceValue,
            'operations' => $operations,
        ]);
    }
}
