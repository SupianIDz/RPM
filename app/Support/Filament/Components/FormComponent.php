<?php

namespace App\Support\Filament\Components;

use Closure;
use Filament\Forms\Components\Field;
use Filament\Forms\Components\Select;

class FormComponent extends Component
{
    /**
     * @param  string  $name
     * @param  Closure $closure
     * @return Field
     */
    public static function input(string $name, Closure $closure) : Field
    {
        return
            tap(self::make($name, $closure), static function ($input) use ($closure) {
                if ($input instanceof Select) {
                    $input->searchable();
                }

                $closure($input);
            });
    }
}
