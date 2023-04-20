<?php

namespace App\Jobs;

use App\Models\User;
use App\Models\UserBalance;
use App\Models\UserBalanceOperations;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\DB;

class ProcessBalance implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $id;

    protected $value;

    protected $type;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($id, $value, $type)
    {
        $this->id = $id;
        $this->value = $value;
        $this->type = $type;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        //DB::beginTransaction();

        try {
            $userBalance = UserBalance::where('user_id', $this->id)->first();
            switch ($this->type) {
                case UserBalanceOperations::TYPE_INCREASE:
                    $userBalance->value = $userBalance->value + $this->value;
                    $userBalance->save();
                    //DB::commit();
                    break;
                case UserBalanceOperations::TYPE_DECREASE:
                    $userBalance->value = $userBalance->value - $this->value;
                    $userBalance->save();
                    //DB::commit();
                    break;
                default:
                    break;
            }
        } catch (\Exception $e) {
            //DB::rollBack();
            abort(500, "Ошибка при выполнении запроса", (array)$e->getMessage());
        }
    }
}
