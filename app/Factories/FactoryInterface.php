<?php

declare(strict_types=1);

namespace App\Factories;

use App\Domain\Calculator\CalculatorInterface;

interface FactoryInterface
{
    /**
     * @return CalculatorInterface
     */
    public function create(): CalculatorInterface;
}
