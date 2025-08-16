<?php

namespace App\Support\Filament\Components;

use Closure;
use Filament\Actions\Action;
use Filament\Tables\Actions\Action as TableAction;
use Filament\Tables\Actions\BulkAction;

class ActionComponent extends Component
{
    /**
     * @param  string|null $name
     * @param  Closure     $closure
     * @return mixed
     */
    public static function action(string|null $name, Closure $closure) : Action|TableAction|BulkAction
    {
        if (is_null($name)) {
            $name = md5(str(static::getTypedParameterClass($closure))->remove('\\')->snake());
        }

        return
            tap(self::make($name, $closure), static function ($column) use ($closure) {
                $closure($column);
            });
    }
}
