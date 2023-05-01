<?php

declare(strict_types=1);

namespace App\Services;

use App\DTO\UserDTO;
use App\Models\User;
use App\Repositories\UserBalanceRepository;
use App\Repositories\UserRepository;

class UserService
{
    public function __construct(
        private UserRepository $userRepository,
        private UserBalanceRepository $userBalanceRepository
    ) {}

    /**
     * @param UserDTO $userDTO
     * @return User
     */
    public function createUser(UserDTO $userDTO): User
    {
        $user =  $this->userRepository->createUser($userDTO);
        $this->userBalanceRepository->createUserBalance($user->id);
        return $user;
    }
}
