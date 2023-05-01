<?php

namespace App\Providers;

use App\Factories\BalanceCalculatorFactory;
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
            return new UserBalanceService(new BalanceCalculatorFactory());
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
