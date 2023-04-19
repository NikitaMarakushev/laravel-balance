<?php

namespace App\Console\Commands;

use App\Jobs\ProcessBalance;
use Illuminate\Console\Command;

class ProcessBalanceOperationsCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'process:user_balance';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        ProcessBalance::dispatch();
        return Command::SUCCESS;
    }
}
