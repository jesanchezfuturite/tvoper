<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        $this->app->bind(\App\Repositories\PortalSolicitudesTicketRepository::class, \App\Repositories\PortalSolicitudesTicketRepositoryEloquent::class);
        $this->app->bind(\App\Repositories\PortalSolicitudesStatusRepository::class, \App\Repositories\PortalSolicitudesStatusRepositoryEloquent::class);
        $this->app->bind(\App\Repositories\PortalSolicitudesMensajesRepository::class, \App\Repositories\PortalSolicitudesMensajesRepositoryEloquent::class);
        //:end-bindings:
    }
}
