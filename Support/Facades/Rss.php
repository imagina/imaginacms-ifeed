<?php

namespace Modules\Ifeeds\Support\Facades;

use Illuminate\Support\Facades\Facade;

class Rss extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'rss';
    }
}
