<?php

namespace Gentor\Userengage\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @see \Gentor\Userengage\UserengageService
 */
class Userengage extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'userengage';
    }
}
