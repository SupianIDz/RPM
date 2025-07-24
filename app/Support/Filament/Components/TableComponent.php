<?php

namespace App\Support\Filament\Components;

use Archilex\ToggleIconColumn\Columns\ToggleIconColumn;
use Closure;
use Filament\Support\Enums\ActionSize;
use Filament\Support\Enums\IconSize;
use Filament\Tables\Columns\Column;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\BaseFilter;
use Filament\Tables\Filters\Filter;

class TableComponent extends Component
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
                    $column->searchable()->copyable()->sortable();
                } else if ($column instanceof ImageColumn) {
                    $column->size(40)->defaultImageUrl(asset('images/wrench.png'))->label('');
                } else if ($column instanceof ToggleIconColumn) {
                    $column->alignCenter()->verticallyAlignCenter();
                    $column
                        ->onIcon('lucide-check-circle-2')
                        ->onColor('success')
                        ->offIcon('lucide-x-circle')
                        ->offColor('danger')
                        ->size('lg');
                }

                $closure($column);
            });
    }

    /**
     * @param  string  $name
     * @param  Closure $closure
     * @return Filter
     */
    public static function filter(string $name, Closure $closure) : BaseFilter
    {
        return
            tap(self::make($name, $closure), static function ($filter) use ($closure) {
                $closure($filter);
            });
    }
}
