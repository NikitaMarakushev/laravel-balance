<?php

namespace App\Console\Commands;

use App\Jobs\ProcessBalance;
use App\Models\UserBalanceOperations;
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
        $count = UserBalanceOperations::count();
        $chunkSize = 20;

        $bar = $this->output->createProgressBar($count);

        UserBalanceOperations::chunk($chunkSize, function ($rows) use ($bar) {
           foreach ($rows as $row) {

           }
           $bar->advance(count($rows));
        });

        $bar->finish();

        return Command::SUCCESS;
    }
}
