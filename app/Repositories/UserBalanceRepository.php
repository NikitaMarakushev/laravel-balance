<?php

declare(strict_types=1);

namespace App\Repositories;

use App\Enum\UserBalanceEnum;
use App\Exceptions\NoSuchUserException;
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

    /**
     * @param $userId
     * @return UserBalance
     */
    public function createUserBalance($userId): UserBalance
    {
        $userBalance = UserBalance::create([
            'user_id' => $userId,
            'value' => UserBalanceEnum::DEFAULT_BALANCE
        ]);

        $userBalance->save();

        return $userBalance;
    }

    /**
     * @param string $email
     * @return UserBalance
     * @throws NoSuchUserException
     */
    public function getUserBalanceByEmail(string $email): UserBalance
    {
        $userBalance = UserBalance::where('email', $email)
            ->select()
            ->join('users', 'users.id', '=', 'user_balance.user_id')
            ->lockForUpdate()
            ->first();

        if (is_null($userBalance)) {
            throw new NoSuchUserException();
        }

        return $userBalance;
    }

    /**
     * @param UserBalance $userBalance
     * @param float $calculationResult
     * @return UserBalance
     */
    public function updateBalance(UserBalance $userBalance, float $calculationResult): UserBalance
    {
        $userBalance->value = $calculationResult;
        $userBalance->save();

        return $userBalance;
    }
}
