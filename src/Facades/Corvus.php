<?php

namespace Corvus\Facades;

use Illuminate\Support\Facades\Facade;

class Corvus extends Facade {

    protected static function getFacadeAccessor() { return 'corvus'; }

}