<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Support\Facades\DB;

class UserBalance extends Model
{
    use HasFactory;

    protected $table = "user_balance";

    protected $fillable = ['user_id', 'value'];

    public $timestamps = false;

    /**
     * @var float
     */
    private float $value;

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

    /**
     * @return float
     */
    public function getValue(): float
    {
        return $this->value;
    }

    /**
     * @param float $value
     */
    public function setValue(float $value): void
    {
        $this->value = $value;
    }

    public function addValue($value)
    {
        DB::beginTransaction();

        try {
            $userBalance = $this->where('user_id', $this->user_id)->lockForUpdate()->firstOrFail();
            $userBalance->update(['value' => $userBalance->value + $value]);

            UserBalanceOperations::create([
                'user_balance_id' => $this->id,
                'value' => $value
            ]);

            DB::commit();

            return $userBalance;
        } catch (\Exception $e) {
            DB::rollBack();
            abort(500, "Ошибка при выполнении запроса", (array)$e->getMessage());
        }
    }
}
