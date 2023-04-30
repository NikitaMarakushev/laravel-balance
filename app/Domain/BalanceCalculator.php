<?php

declare(strict_types=1);

namespace App\Domain;

use App\DTO\UserBalanceDTO;
use App\Enum\UserBalanceOperationsEnum;

class BalanceCalculator
{
    /**
     * @param UserBalanceDTO $userBalanceDTO
     * @param float $value
     */
    public function __construct(
        private UserBalanceDTO $userBalanceDTO,
        private float $value
    ) {}

    /**
     * @return float
     */
    public function calculate(): float
    {
        if ($this->userBalanceDTO->getType() === UserBalanceOperationsEnum::TYPE_INCREASE) {
            return $this->value + $this->userBalanceDTO->getValue();
        }

        return $this->value - $this->userBalanceDTO->getValue();
    }
}
