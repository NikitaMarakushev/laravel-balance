<?php

declare(strict_types=1);

namespace App\Factories;

use App\Domain\Calculator\BalanceCalculator;
use App\Domain\Calculator\CalculatorInterface;

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
