<?php

declare(strict_types=1);

namespace App\Services;

use App\DTO\UserDTO;
use App\Enum\UserBalanceEnum;
use App\Models\User;
use App\Models\UserBalance;
use Illuminate\Support\Facades\Hash;

class UserService
{
    /**
     * @param UserDTO $userDTO
     * @return User
     */
    public function createUser(UserDTO $userDTO): User
    {
        $user = User::create([
            'name' => $userDTO->getName(),
            'email' => $userDTO->getEmail(),
            'password' => Hash::make($userDTO->getPassword()),
        ]);
        $user->save();
        UserBalance::create([
            'user_id' => $user->id,
            'value' => UserBalanceEnum::DEFAULT_BALANCE
        ])->save();

        return $user;
    }
}
