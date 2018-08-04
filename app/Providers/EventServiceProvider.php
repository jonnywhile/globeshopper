<?php

namespace App\Providers;

use Illuminate\Support\Facades\Event;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        'App\Events\Event' => [
            'App\Listeners\EventListener',
        ],
        'App\Domain\Offers\OfferCreated' => [
            'App\Domain\Requests\RequestChangeListener',
        ],
        'App\Domain\Requests\RequestAccepted' => [
            'App\Domain\Requests\RequestChangeListener',
        ],
        'App\Domain\Requests\RequestCancelled' => [
            'App\Domain\Requests\RequestChangeListener',
        ],
        'App\Domain\Requests\RequestDelivered' => [
            'App\Domain\Requests\RequestChangeListener',
        ],
        'App\Domain\Requests\RequestCharged' => [
            'App\Domain\Requests\RequestChangeListener',
        ],
    ];

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {
        parent::boot();

        //
    }
}
