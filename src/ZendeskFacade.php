<?php
namespace Appricot\Zendesk;

use Illuminate\Support\Facades\Facade;

class ZendeskFacade extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'zendesk';
    }
}
