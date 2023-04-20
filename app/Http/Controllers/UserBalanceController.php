<?php

declare(strict_types=1);

namespace App\Http\Controllers;

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

        ProcessBalance::dispatch($request->user, $request->value, $request->type, $request->description);

        return redirect('/home');
    }
}
