<?php

declare(strict_types=1);

namespace App\Repositories;

use App\Models\UserBalance;

class UserBalanceRepository
{
    /**
     * @param int $userId
     * @return mixed
     */
    public function getUserBalanceById(int $userId): UserBalance
    {
        return UserBalance::query()
            ->select('value', 'id')
            ->where('user_id', $userId)
            ->get()
            ->first();
    }
}
