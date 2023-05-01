<?php

declare(strict_types=1);

namespace App\Domain\Calculator;

interface CalculatorInterface
{
    /**
     * @param float $firstValue
     * @param float $secondValue
     * @param string $operationType
     * @return float
     */
    public function calculate(float $firstValue, float $secondValue, string $operationType): float;
}
