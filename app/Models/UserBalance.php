<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class UserBalance extends Model
{
    use HasFactory;

    protected $table = "user_balance";

    protected $fillable = ['user_id', 'value'];

    public $timestamps = false;

    /**
     * @return HasOne
     */
    public function user(): HasOne
    {
        return $this->hasOne(User::class);
    }

    /**
     * @return HasMany
     */
    public function userBalanceOperations(): HasMany
    {
        return $this->hasMany(UserBalanceOperations::class);
    }
}
