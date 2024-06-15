<?php

namespace App\Providers;

use App\Events\Bayi\PemeriksaanBayiCreated;
use App\Events\Bayi\PemeriksaanBayiUpdated;
use App\Events\Lansia\PemeriksaanLansiaCreated;
use App\Events\Lansia\PemeriksaanLansiaUpdated;
use App\Listeners\Bayi\LogPemeriksaanBayiCreation;
use App\Listeners\Bayi\LogPemeriksaanBayiUpdation;
use App\Listeners\Lansia\LogPemeriksaanLansiaCreation;
use App\Listeners\Lansia\LogPemeriksaanLansiaUpdation;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event to listener mappings for the application.
     *
     * @var array<class-string, array<int, class-string>>
     */
    protected $listen = [
        PemeriksaanBayiCreated::class => [
            LogPemeriksaanBayiCreation::class,
        ],
        PemeriksaanBayiUpdated::class => [
            LogPemeriksaanBayiUpdation::class
        ],
        PemeriksaanLansiaCreated::class => [
            LogPemeriksaanLansiaCreation::class,
        ],
        PemeriksaanLansiaUpdated::class => [
            LogPemeriksaanLansiaUpdation::class,
        ],
    ];

    /**
     * Register any events for your application.
     */
    public function boot(): void
    {
        //
    }

    /**
     * Determine if events and listeners should be automatically discovered.
     */
    public function shouldDiscoverEvents(): bool
    {
        return false;
    }
}
