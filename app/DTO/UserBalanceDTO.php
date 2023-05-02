<?php

declare(strict_types=1);

namespace App\DTO;

class UserBalanceDTO
{
    /**
     * @param string $userEmail
     * @param float $value
     * @param string $type
     * @param string $description
     */
    public function __construct(
        private string $userEmail,
        private float $value,
        private string $type,
        private string $description
    ) {}

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

    /**
     * @return string
     */
    public function getUserEmail(): string
    {
        return $this->userEmail;
    }
}
