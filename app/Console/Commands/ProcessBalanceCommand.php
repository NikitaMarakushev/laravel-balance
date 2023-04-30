<?php

declare(strict_types=1);

namespace App\Console\Commands;

use App\DTO\UserBalanceDTO;
use App\Enum\UserBalanceOperationsEnum;
use App\Jobs\ProcessBalance;
use Illuminate\Console\Command;
use Symfony\Component\Console\Command\Command as CommandAlias;

class ProcessBalanceCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'process:balance';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Run the ProcessBalance job for update balance of user';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle(): int
    {
        $userLogin = $this->ask('Please enter your login');
        $value = $this->ask('Please enter your value');
        $type = $this->choice(
            'Please chose your type',
            [UserBalanceOperationsEnum::TYPE_INCREASE, UserBalanceOperationsEnum::TYPE_DECREASE]
        );
        $description = $this->ask('Please enter your description');
        $userBalanceDTO = new UserBalanceDTO(
            $userLogin,
            (float)$value,
            $type,
            $description
        );
        ProcessBalance::dispatch($userBalanceDTO);
        $this->info('The job to change the balance was successfully sent to the queue!');
        return CommandAlias::SUCCESS;
    }
}
