<?php

use App\Support\Filament\Components\ActionComponent;
use App\Support\Filament\Components\FormComponent;
use App\Support\Filament\Components\InfolistComponent;
use App\Support\Filament\Components\TableComponent;
use App\User\Models\User;
use Filament\Actions\Action;
use Filament\Forms\Components\Field;
use Filament\Infolists\Components\Entry;
use Filament\Tables\Actions\Action as TableAction;
use Filament\Tables\Actions\BulkAction;
use Filament\Tables\Columns\Column;
use Filament\Tables\Filters\BaseFilter;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Contracts\Container\BindingResolutionException;
use Illuminate\Contracts\Filesystem\Filesystem;
use Illuminate\Pipeline\Pipeline;

if (! function_exists('pipeline')) {
    /**
     * @param  mixed $passable
     * @param  array $through
     * @return Pipeline
     * @throws BindingResolutionException
     */
    function pipeline(mixed $passable, array $through = []) : Pipeline
    {
        $pipe = App::make(Pipeline::class)->send($passable);

        if (! empty($through)) {
            return $pipe->through($through);
        }

        return $pipe;
    }
}

if (! function_exists('user')) {
    /**
     * @return User|Authenticatable|null
     */
    function user() : User|Authenticatable|null
    {
        return auth()->user();
    }
}

if (! function_exists('storage')) {
    /**
     * @param  string|null $disk
     * @return Filesystem
     */
    function storage(string|null $disk = null) : Filesystem
    {
        return \Illuminate\Support\Facades\Storage::disk($disk);
    }
}

if (! function_exists('number')) {
    /**
     * @param  int|string $number
     * @return \App\Support\Number
     */
    function number(int|string $number) : \App\Support\Number
    {
        return new \App\Support\Number($number);
    }
}

if (! function_exists('fi_entry')) {
    /**
     * @param  string  $name
     * @param  Closure $closure
     * @return Entry
     */
    function fi_entry(string $name, Closure $closure) : Entry
    {
        return InfolistComponent::entry($name, $closure);
    }
}

if (! function_exists('fi_ta_column')) {
    /**
     * @param  string  $column
     * @param  Closure $callback
     * @return Column
     */
    function fi_ta_column(string $column, Closure $callback) : Column
    {
        return TableComponent::column($column, $callback);
    }
}

if (! function_exists('fi_ta_filter')) {
    /**
     * @param  Closure     $callback
     * @param  string|null $name
     * @return BaseFilter
     */
    function fi_ta_filter(Closure $callback, string|null $name = null) : BaseFilter
    {
        if (is_null($name)) {
            $name = 'filter-' . \Illuminate\Support\Str::random(10);
        }

        return TableComponent::filter($name, $callback);
    }
}

if (! function_exists('fi_action')) {
    /**
     * @param  Closure     $callback
     * @param  string|null $name
     * @return Action|TableAction|BulkAction
     */
    function fi_action(Closure $callback, string|null $name = null) : Action|TableAction|BulkAction
    {
        return ActionComponent::action($name, $callback);
    }
}

if (! function_exists('fi_form_field')) {
    /**
     * @param  string  $name
     * @param  Closure $callback
     * @return Field
     */
    function fi_form_field(string $name, Closure $callback) : mixed
    {
        return FormComponent::input($name, $callback);
    }
}

if (! function_exists('fi_wi_stat')) {
    /**
     * @param  Closure $closure
     * @return Stat
     */
    function fi_wi_stat(Closure $closure) : Stat
    {
        $stat = Stat::make('', '');

        $value = $closure($stat);

        if (filled($value)) {
            $stat->value($value);
        }

        return $stat;
    }
}

if (! function_exists('str_invoice')) {
    /**
     * @param  int $number
     * @return string
     */
    function str_invoice(int $number = 5) : string
    {
        return 'INV' . date('Ymd') . '-' . strtoupper(\Illuminate\Support\Str::random($number));
    }
}
