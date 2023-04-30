<?php

declare(strict_types=1);

namespace App\Jobs;

use App\DTO\UserBalanceDTO;
use App\Enum\UserBalanceOperationsEnum;
use App\Models\UserBalance;
use App\Models\UserBalanceOperations;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\DB;

class ProcessBalance implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * @var UserBalanceDTO
     */
    protected UserBalanceDTO $userBalanceDTO;

    /**
     * @param UserBalanceDTO $userBalanceDTO
     */
    public function __construct(UserBalanceDTO $userBalanceDTO)
    {
        $this->userBalanceDTO = $userBalanceDTO;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        DB::beginTransaction();

        try {
            $userBalance = UserBalance::where('email', $this->userBalanceDTO->getUserLogin())->first();
            switch ($this->userBalanceDTO->getType()) {
                case UserBalanceOperationsEnum::TYPE_INCREASE:
                    $userBalance->value = $userBalance->value + $this->userBalanceDTO->getValue();
                    break;
                case UserBalanceOperationsEnum::TYPE_DECREASE:
                    $userBalance->value = $userBalance->value - $this->userBalanceDTO->getValue();
                    break;
                default:
                    break;
            }

            $userBalance->save();
            /** @TODO Имеет смысл вынести отсюда */
            UserBalanceOperations::create([
                'user_balance_id' => $userBalance->id,
                'date' => new \DateTime(),
                'type' => $this->userBalanceDTO->getType(),
                'value' => $this->userBalanceDTO->getValue(),
                'description' => $this->userBalanceDTO->getDescription()
            ])->save();
            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            abort(500, "Ошибка при выполнении запроса", (array)$e->getMessage());
        }
    }
}
