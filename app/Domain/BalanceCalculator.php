<?php

declare(strict_types=1);

namespace App\Domain;

use App\Enum\UserBalanceOperationsEnum;

class BalanceCalculator implements CalculatorInterface
{
    public function calculate(float $firstValue, float $secondValue, string $operationType): float
    {
        if ($operationType === UserBalanceOperationsEnum::TYPE_INCREASE) {
            return $firstValue + $secondValue;
        }

        return $firstValue - $secondValue;
    }
}
