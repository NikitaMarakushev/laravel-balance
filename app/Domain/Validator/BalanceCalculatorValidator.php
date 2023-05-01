<?php

declare(strict_types=1);

namespace App\Domain\Validator;

use App\Exceptions\NegativeBalanceException;

class BalanceCalculatorValidator
{
    /**
     * @param float $calculationResult
     * @return void
     * @throws NegativeBalanceException
     */
    public function validate(float $calculationResult): void
    {
        if ($calculationResult < 0) {
            throw new NegativeBalanceException("User balance can not be negative!");
        }
    }
}
