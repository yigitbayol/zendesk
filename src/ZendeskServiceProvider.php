<?php

namespace Appricot\Zendesk;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\App;

use Zendesk;

class ZendeskServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind('zendesk',function(){
          return new Zendesk();
        });
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
