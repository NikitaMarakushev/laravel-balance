<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Repositories\UserBalanceOperationsRepository;
use App\Repositories\UserBalanceRepository;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(
        private UserBalanceRepository $userBalanceRepository,
        private UserBalanceOperationsRepository $userBalanceOperationsRepository
    ) {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return Renderable
     */
    public function index()
    {
        $userBalance = $this->userBalanceRepository->getUserBalanceById(Auth::user()->id);
        $operations = $this->userBalanceOperationsRepository->getOperations($userBalance->id);

        return view('home', [
            'current_user' => Auth::user()->name,
            'user_balance' => $userBalance->value,
            'operations' => $operations,
        ]);
    }

    /**
     * @return string
     */
    public function getOperations(): string
    {
        $userBalance = $this->userBalanceRepository->getUserBalanceById(Auth::user()->id);
        return json_encode($this->userBalanceOperationsRepository->getOperations($userBalance));
    }
}
