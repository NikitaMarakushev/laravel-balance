<?php

declare(strict_types=1);

namespace App\Console\Commands;

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
    protected $signature = 'process:balance {user_id} {value} {type} {description}';

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
        $user = $this->option('user_id');
        if ($user === null) {
            $user = $this->ask('Please enter your user_id.');
        }
        $value = $this->option('value');
        if ($value === null) {
            $value = $this->ask('Please enter your value.');
        }
        $type = $this->option('type');
        if ($type === null) {
            $type = $this->ask('Please enter your type.');
        }
        $description = $this->option('description');
        if ($description === null) {
            $description = $this->ask('Please enter your type.');
        }

        ProcessBalance::dispatch($user, $value, $type, $description);

        return CommandAlias::SUCCESS;
    }
}
