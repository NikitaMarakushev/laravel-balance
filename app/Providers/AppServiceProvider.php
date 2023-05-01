<?php

namespace App\Providers;

use App\Domain\Validator\BalanceCalculatorValidator;
use App\Factories\BalanceCalculatorFactory;
use App\Repositories\UserBalanceOperationsRepository;
use App\Repositories\UserBalanceRepository;
use App\Services\UserBalanceService;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(UserBalanceService::class, function ($app) {
            return new UserBalanceService(
                new BalanceCalculatorFactory(),
                new UserBalanceRepository(),
                new UserBalanceOperationsRepository(),
                new BalanceCalculatorValidator()
            );
        });
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
