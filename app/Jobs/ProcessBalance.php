<?php

declare(strict_types=1);

namespace App\Jobs;

use App\Models\UserBalance;
use App\Models\UserBalanceOperations;
use Illuminate\Bus\Queueable;;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\DB;

class ProcessBalance implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected string $id;

    protected float $value;

    protected string $type;

    protected string $description;

    /**
     * @param string $id
     * @param float $value
     * @param string $type
     * @param string $description
     */
    public function __construct(string $id, float $value, string $type, string $description)
    {
        $this->id = $id;
        $this->value = $value;
        $this->type = $type;
        $this->description = $description;
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
            $userBalance = UserBalance::where('user_id', $this->id)->first();
            switch ($this->type) {
                case UserBalanceOperations::TYPE_INCREASE:
                    $userBalance->value = $userBalance->value + $this->value;
                    $userBalance->save();
                    DB::commit();
                    break;
                case UserBalanceOperations::TYPE_DECREASE:
                    $userBalance->value = $userBalance->value - $this->value;
                    $userBalance->save();
                    DB::commit();
                    break;
                default:
                    break;
            }

            UserBalanceOperations::create([
                'user_balance_id' => $userBalance->id,
                'date' => new \DateTime(),
                'type' => $this->type,
                'value' => $this->value,
                'completed_at' => new \DateTime(),
                'description' => $this->description
            ])->save();

        } catch (\Exception $e) {
            DB::rollBack();
            abort(500, "Ошибка при выполнении запроса", (array)$e->getMessage());
        }
    }
}
