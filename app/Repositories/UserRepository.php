<?php

declare(strict_types=1);

namespace App\Repositories;

use App\DTO\UserDTO;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserRepository
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

        return $user;
    }
}
