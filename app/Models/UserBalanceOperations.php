<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class UserBalanceOperations extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $fillable = ['user_balance_id', 'date', 'type', 'value', 'description'];

    /**
     * @return BelongsTo
     */
    public function userBalance(): BelongsTo
    {
        return $this->belongsTo(UserBalance::class);
    }
}
