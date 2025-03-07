<?php

namespace App\Providers;
use Illuminate\Database\Schema\Builder;
use Illuminate\Support\ServiceProvider;
use App\Models\Tontine;
use App\Policies\TontinePolicy;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    protected $policies = [
        Tontine::class => TontinePolicy::class,
    ];

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
        Builder::defaultStringLength(191);
    }
}
