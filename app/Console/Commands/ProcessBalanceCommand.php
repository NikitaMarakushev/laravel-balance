<?php

declare(strict_types=1);

namespace App\Console\Commands;

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
        $user = $this->ask('Please enter your user_id.');
        $value = $this->ask('Please enter your value.');
        $type = $this->choice(
            'Please chose your type',
            [UserBalanceOperationsEnum::TYPE_INCREASE, UserBalanceOperationsEnum::TYPE_DECREASE]
        );
        $description = $this->ask('Please enter your description.');

        ProcessBalance::dispatch($user, $value, $type, $description);
        $this->info('Balance processed successfully!');
        return CommandAlias::SUCCESS;
    }
}
