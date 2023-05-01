<?php

declare(strict_types=1);

namespace App\Repositories;

use App\Enum\UserBalanceEnum;
use App\Models\UserBalanceOperations;
use Illuminate\Contracts\Queue\QueueableCollection;

class UserBalanceOperationsRepository
{
    /**
     * @param int $userBalanceId
     * @return QueueableCollection
     */
    public function getOperations(int $userBalanceId): QueueableCollection
    {
        return UserBalanceOperations::query()
            ->where('user_balance_id', $userBalanceId)
            ->orderBy('id', 'desc')
            ->take(UserBalanceEnum::MAX_PER_PAGE)
            ->get();
    }
}
