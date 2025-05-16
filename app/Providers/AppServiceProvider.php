<?php

namespace App\Providers;

use App\Repositories\Interfaces\EmailDisparoRepositoryInterface;
use App\Repositories\Eloquent\EmailDisparoRepository;

use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(EmailDisparoRepositoryInterface::class, EmailDisparoRepository::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
