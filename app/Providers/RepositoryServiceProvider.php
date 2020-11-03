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
        $this->app->bind(\App\Repositories\PortalNotaryRepository::class, \App\Repositories\PortalNotaryRepositoryEloquent::class);
        $this->app->bind(\App\Repositories\ConfigUserNotaryOfficeRepository::class, \App\Repositories\ConfigUserNotaryOfficeRepositoryEloquent::class);
        $this->app->bind(\App\Repositories\PortalConfigUserNotaryOfficeRepository::class, \App\Repositories\PortalConfigUserNotaryOfficeRepositoryEloquent::class);
        //:end-bindings:
    }
}
