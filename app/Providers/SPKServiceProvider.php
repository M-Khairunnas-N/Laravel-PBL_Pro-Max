<?php

namespace App\Providers;

use App\Services\MabacServices;
use App\Services\SAWServices;
use Illuminate\Contracts\Support\DeferrableProvider;
use Illuminate\Support\ServiceProvider;

class SPKServiceProvider extends ServiceProvider implements DeferrableProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->singleton(MabacServices::class, function () {
            return new MabacServices();
        });

        $this->app->singleton(SAWServices::class, function () {
            return new SAWServices();
        });
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }

    /**
     * so in this method, you can return Service Provider that had to be
     * lazy loaded, so only loaded when we called those class
     *
     * but in order to refresh cache that compile our service provider by
     * laravel, we need to clear cache-compiled, you can do this by artisan
     * command: 'php artisan clear-compiled'
     *
     * and to check artisan command that can clear you can do
     * command: 'php artisan | grep clear'
     */
    public function provides(): array
    {
        return [MabacServices::class, SAWServices::class];
    }

}
