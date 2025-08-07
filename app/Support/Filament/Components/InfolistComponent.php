<?php

namespace App\Support\Filament\Components;

use Closure;
use Filament\Forms\Components\Field;
use Filament\Infolists\Components\Entry;

class InfolistComponent extends Component
{
    /**
     * @param  string  $name
     * @param  Closure $closure
     * @return Entry
     */
    public static function entry(string $name, Closure $closure) : Entry
    {
        return
            tap(self::make($name, $closure), static function ($entry) use ($closure) {
              $closure($entry);
            });
    }
}
