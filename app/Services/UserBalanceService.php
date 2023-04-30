<?php

declare(strict_types=1);

namespace App\Services;

use App\Domain\BalanceCalculator;
use App\DTO\UserBalanceDTO;
use App\Exceptions\NegativeBalanceException;
use App\Models\UserBalance;
use App\Models\UserBalanceOperations;

class UserBalanceService
{
    /**
     * @param UserBalanceDTO $userBalanceDTO
     * @return void
     * @throws NegativeBalanceException
     */
    public function processBalance(UserBalanceDTO $userBalanceDTO): void
    {
        $userBalance = UserBalance::where('email', $userBalanceDTO->getUserLogin())
            ->select()
            ->join('users', 'users.id', '=', 'user_balance.user_id')
            ->lockForUpdate()
            ->first();

        $calculationResult = (new BalanceCalculator($userBalanceDTO, $userBalance->value))->calculate();

        if ($calculationResult < 0) {
            throw new NegativeBalanceException("User balance can not be negative!");
        }

        $userBalance->value = $calculationResult;
        $userBalance->save();

        UserBalanceOperations::create([
            'user_balance_id' => $userBalance->id,
            'date' => new \DateTime(),
            'type' => $userBalanceDTO->getType(),
            'value' => $userBalanceDTO->getValue(),
            'description' => $userBalanceDTO->getDescription()
        ])->save();
    }
}
