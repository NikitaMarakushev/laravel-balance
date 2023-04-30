<?php

declare(strict_types=1);

namespace App\Console\Commands;

use App\DTO\UserDTO;
use App\Services\UserService;
use Illuminate\Console\Command;
use Symfony\Component\Console\Command\Command as CommandAlias;

class CreateUserCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'user:create';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create new user through CLI artisan';

    /**
     * @var UserService
     */
    private UserService $userService;

    /**
     * @param UserService $userService
     */
    public function __construct(UserService $userService)
    {
        parent::__construct();
        $this->userService = $userService;
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle(): int
    {
        $name = $this->ask('Please enter your username.');
        $email = $this->ask('Please enter your E-Mail.');
        $password = $this->secret('Please enter a new password.');
        $passwordConfirmation = $this->secret('Please confirm the password');

        if ($password !== $passwordConfirmation) {
            $this->error('Your passwords do not match!');
            return CommandAlias::FAILURE;
        }

        $userDTO = new UserDTO($name, $email, $password);

        try {
            $user = $this->userService->createUser($userDTO);
        } catch (\Exception $e) {
            $this->error($e->getMessage());
            return CommandAlias::FAILURE;
        }

        $this->info('User created successfully!');
        $this->info('New user id: ' . $user->id);
        return CommandAlias::SUCCESS;
    }
}
