<?php

namespace App\Http\Controllers;

use App\Jobs\ProcessBalance;
use App\Models\UserBalance;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use InvalidArgumentException;

class UserBalanceController extends Controller
{
    public function change(Request $request)
    {
        if (!$request->user) {
            throw new InvalidArgumentException("No 'user' param found");
        }

        if (!$request->value) {
            throw new InvalidArgumentException("No 'value' param found");
        }

        if (!$request->type) {
            throw new InvalidArgumentException("No 'type' param found");
        }

        echo '<pre>';

        ProcessBalance::dispatch($request->user, $request->value, $request->type);

        return redirect('/home');
    }
}
