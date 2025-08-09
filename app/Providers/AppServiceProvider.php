<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        // Register the CategoryRepositoryInterface with its implementation
        $this->app->bind(
            \App\Interface\CategoryRepositoryInterface::class,
            \App\Repositories\CategoryRepository::class
        );
        // Register the TransactionRepositoryInterface with its implementation
        $this->app->bind(
            \App\Interface\TransactionRepositoryInterface::class,
            \App\Repositories\TransactionRepository::class
        );
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
