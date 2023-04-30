<?php

declare(strict_types=1);

namespace App\Jobs;

use App\DTO\UserBalanceDTO;
use App\Exceptions\NegativeBalanceException;
use App\Services\UserBalanceService;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class ProcessBalance implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * @var UserBalanceDTO
     */
    protected UserBalanceDTO $userBalanceDTO;

    /**
     * @var UserBalanceService
     */
    protected UserBalanceService $userBalanceService;

    /**
     * @param UserBalanceDTO $userBalanceDTO
     * @param UserBalanceService $userBalanceService
     */
    public function __construct(UserBalanceDTO $userBalanceDTO, UserBalanceService $userBalanceService)
    {
        $this->userBalanceDTO = $userBalanceDTO;
        $this->userBalanceService = $userBalanceService;
    }

    /**
     * Execute the job.
     *
     * @return void
     * @throws NegativeBalanceException
     */
    public function handle(): void
    {
        $this->userBalanceService->processBalance($this->userBalanceDTO);
    }
}
