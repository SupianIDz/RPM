<?php

namespace App\Support\Filament\Components;

use Closure;
use Filament\Tables\Columns\Column;
use Filament\Tables\Columns\TextColumn;

class TableComponent extends Factory
{
    /**
     * @param  string  $name
     * @param  Closure $closure
     * @return mixed
     */
    public static function column(string $name, Closure $closure) : Column
    {
        return
            tap(self::make($name, $closure), static function ($column) use ($closure) {
                if ($column instanceof TextColumn) {
                    $column->searchable();
                }

                $closure($column);
            });
    }
}
