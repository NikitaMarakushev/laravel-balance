<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\DTO\UserBalanceDTO;
use App\Jobs\ProcessBalance;
use Illuminate\Http\Request;

class UserBalanceController extends Controller
{
    public function updateBalance(Request $request)
    {
        $request->validate([
            'user' => 'required',
            'value' => 'required',
            'type' => 'required',
            'description' => 'required'
        ]);

        $userBalanceDTO = new UserBalanceDTO(
            $request->user,
            $request->value,
            $request->type,
            $request->description
        );

        ProcessBalance::dispatch($userBalanceDTO);

        return redirect('/home');
    }
}
