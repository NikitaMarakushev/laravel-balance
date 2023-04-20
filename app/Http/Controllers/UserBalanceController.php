<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Jobs\ProcessBalance;
use Illuminate\Http\Request;
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

        ProcessBalance::dispatch($request->user, $request->value, $request->type, $request->description);

        return redirect('/home');
    }
}
