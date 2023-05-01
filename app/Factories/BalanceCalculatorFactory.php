<?php

declare(strict_types=1);

namespace App\Factories;

use App\Domain\BalanceCalculator;
use App\Domain\CalculatorInterface;

class BalanceCalculatorFactory implements FactoryInterface
{
    /**
     * @return CalculatorInterface
     */
    public function create(): CalculatorInterface
    {
        return new BalanceCalculator();
    }
}
