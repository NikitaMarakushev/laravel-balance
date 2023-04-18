<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class UserBalanceOperations extends Model
{
    use HasFactory;

    public const TYPE_INCREASE = 'increase';

    public const TYPE_DECREASE = 'decrease';

    public $timestamps = false;

    /**
     * @var string
     */
    private string $date;

    /**
     * @var string
     */
    private string $type;

    /**
     * @var string
     */
    private string $value;

    /**
     * @var string
     */
    private string $description;

    /**
     * @return BelongsTo
     */
    public function userBalance(): BelongsTo
    {
        return $this->belongsTo(UserBalance::class);
    }

    /**
     * @return string
     */
    public function getDate(): string
    {
        return $this->date;
    }

    /**
     * @param string $date
     */
    public function setDate(string $date): void
    {
        $this->date = $date;
    }

    /**
     * @return string
     */
    public function getType(): string
    {
        return $this->type;
    }

    /**
     * @param string $type
     */
    public function setType(string $type): void
    {
        $this->type = $type;
    }

    /**
     * @return string
     */
    public function getValue(): string
    {
        return $this->value;
    }

    /**
     * @param string $value
     */
    public function setValue(string $value): void
    {
        $this->value = $value;
    }

    /**
     * @return string
     */
    public function getDescription(): string
    {
        return $this->description;
    }

    /**
     * @param string $description
     */
    public function setDescription(string $description): void
    {
        $this->description = $description;
    }
}
