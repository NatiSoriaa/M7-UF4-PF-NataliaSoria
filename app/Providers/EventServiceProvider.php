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
        // Aquí puedes registrar los eventos y los escuchadores, por ejemplo:
        // 'App\Events\SomeEvent' => [
        // 'App\Listeners\SomeEventListener',
        // ],
    ];
    /**
     * Registra cualquier servicio de eventos.
     *
     * @return void
     */
    public function boot()
    {
        parent::boot();
    }
}
