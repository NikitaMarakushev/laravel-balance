<?php

declare(strict_types=1);

namespace App\DTO;

class UserBalanceDTO
{
    public function __construct(
        private string $id,
        private float $value,
        private string $type,
        private string $description
    ) {}

    /**
     * @return string
     */
    public function getId(): string
    {
        return $this->id;
    }

    /**
     * @return float
     */
    public function getValue(): float
    {
        return $this->value;
    }

    /**
     * @return string
     */
    public function getType(): string
    {
        return $this->type;
    }

    /**
     * @return string
     */
    public function getDescription(): string
    {
        return $this->description;
    }
}
