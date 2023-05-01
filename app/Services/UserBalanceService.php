<?php

declare(strict_types=1);

namespace App\Services;

use App\Domain\Validator\BalanceCalculatorValidator;
use App\DTO\UserBalanceDTO;
use App\Exceptions\NegativeBalanceException;
use App\Factories\FactoryInterface;
use App\Repositories\UserBalanceOperationsRepository;
use App\Repositories\UserBalanceRepository;

class UserBalanceService
{
    public function __construct(
        private FactoryInterface $factory,
        private UserBalanceRepository $userBalanceRepository,
        private UserBalanceOperationsRepository $userBalanceOperationsRepository,
        private BalanceCalculatorValidator $balanceCalculatorValidator
    ) {}

    /**
     * @param UserBalanceDTO $userBalanceDTO
     * @return void
     * @throws NegativeBalanceException
     */
    public function processBalance(UserBalanceDTO $userBalanceDTO): void
    {
        $userBalance = $this->userBalanceRepository->getUserBalanceByEmail($userBalanceDTO->getUserLogin());
        $calculationResult = $this->factory->create()->calculate(
            (float)$userBalance->value, $userBalanceDTO->getValue(), $userBalanceDTO->getType()
        );
        $this->balanceCalculatorValidator->validate($calculationResult);
        $this->userBalanceRepository->updateBalance($userBalance, $calculationResult);
        $this->userBalanceOperationsRepository->createUserBalanceOperation($userBalance, $userBalanceDTO);
    }
}
