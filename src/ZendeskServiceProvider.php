<?php

namespace Appricot\Zendesk;

use Illuminate\Support\ServiceProvider;

class ZendeskServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->make('Appricot\Zendesk\ZendeskController');
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        include __DIR__.'/routes.php';
    }
}
