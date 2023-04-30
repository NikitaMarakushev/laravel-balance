<?php

declare(strict_types=1);

namespace App\Services;

use App\DTO\UserBalanceDTO;
use App\Enum\UserBalanceOperationsEnum;
use App\Models\UserBalance;
use App\Models\UserBalanceOperations;
use Illuminate\Support\Facades\DB;

class UserBalanceService
{
    /**
     * @param UserBalanceDTO $userBalanceDTO
     * @return void
     */
    public function processBalance(UserBalanceDTO $userBalanceDTO): void
    {
        DB::beginTransaction();

        try {
            $userBalance = UserBalance::where('email', $userBalanceDTO->getUserLogin())
                ->select()
                ->join('users', 'users.id', '=', 'user_balance.user_id')
                ->where('email', $userBalanceDTO->getUserLogin())
                ->lockForUpdate()
                ->first();

            switch ($userBalanceDTO->getType()) {
                case UserBalanceOperationsEnum::TYPE_INCREASE:
                    $userBalance->value = $userBalance->value + $userBalanceDTO->getValue();
                    break;
                case UserBalanceOperationsEnum::TYPE_DECREASE:
                    $userBalance->value = $userBalance->value - $userBalanceDTO->getValue();
                    break;
                default:
                    break;
            }

            $userBalance->save();

            UserBalanceOperations::create([
                'user_balance_id' => $userBalance->id,
                'date' => new \DateTime(),
                'type' => $userBalanceDTO->getType(),
                'value' => $userBalanceDTO->getValue(),
                'description' => $userBalanceDTO->getDescription()
            ])->save();
            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            abort(500, "Ошибка при выполнении запроса", (array)$e->getMessage());
        }
    }
}
