<?php

declare(strict_types=1);

namespace App\Repositories;

use App\DTO\UserBalanceDTO;
use App\Enum\UserBalanceEnum;
use App\Models\UserBalance;
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

    /**
     * @param UserBalance $userBalance
     * @param UserBalanceDTO $userBalanceDTO
     * @return mixed
     */
    public function createUserBalanceOperation(UserBalance $userBalance, UserBalanceDTO $userBalanceDTO): UserBalanceOperations
    {
        $userBalanceOperation = UserBalanceOperations::create([
            'user_balance_id' => $userBalance->id,
            'date' => new \DateTime(),
            'type' => $userBalanceDTO->getType(),
            'value' => $userBalanceDTO->getValue(),
            'description' => $userBalanceDTO->getDescription()
        ]);

        $userBalanceOperation->save();

        return $userBalanceOperation;
    }
}
