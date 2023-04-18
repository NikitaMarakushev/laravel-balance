<?php

namespace App\Console\Commands;

use App\Models\User;
use App\Models\UserBalance;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Hash;

class CreateUserCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'user:create {--u|username= : Username of the newly created user.} {--e|email= : E-Mail of the newly created user.}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create new user through CLI artisan';

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $name = $this->option('username');
        if ($name === null) {
            $name = $this->ask('Please enter your username.');
        }

        $email = $this->option('email');
        if ($email === null) {
            $email = $this->ask('Please enter your E-Mail.');
        }

        $password = $this->secret('Please enter a new password.');
        $password_confirmation = $this->secret('Please confirm the password');

        $input = [
            'name' => $name,
            'email' => $email,
            'password' => $password,
            'password_confirmation' => $password_confirmation
        ];

        try {
            $user = User::create([
                'name' => $input['name'],
                'email' => $input['email'],
                'password' => Hash::make($input['password']),
            ]);
            $userBalance = UserBalance::create([
                'user_id' => $user->id,
                'value' => 0
            ]);
        } catch (\Exception $e) {
            $this->error($e->getMessage());
            return;
        }

        $this->info('User created successfully!');
        $this->info('New user id: ' . $user->id);
    }
}
