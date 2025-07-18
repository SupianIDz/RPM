<?php

namespace App\Support\Filament\Components;

use Closure;
use Laravel\SerializableClosure\Support\ReflectionClosure;

abstract class Factory
{
    /**
     * @param  string  $name
     * @param  Closure $closure
     * @return mixed
     */
    protected static function make(string $name, Closure $closure) : mixed
    {
        return static::getTypedParameterClass($closure)::make($name);
    }

    /**
     * @param  Closure $closure
     * @param  int     $pointer
     * @return class-string
     */
    protected static function getTypedParameterClass(Closure $closure, int $pointer = 0) : string
    {
        return new ReflectionClosure($closure)->getParameters()[$pointer]->getType()?->getName();
    }
}
