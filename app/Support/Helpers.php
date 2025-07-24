<?php

use App\Support\Filament\Components\ActionComponent;
use App\Support\Filament\Components\FormComponent;
use App\Support\Filament\Components\TableComponent;
use App\User\Models\User;
use Filament\Actions\Action;
use Filament\Forms\Form;
use Filament\Tables\Actions\Action as TableAction;
use Filament\Tables\Columns\Column;
use Filament\Tables\Filters\BaseFilter;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Contracts\Container\BindingResolutionException;
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
     * @return Action|TableAction
     */
    function fi_action(Closure $callback, string|null $name = null) : Action|TableAction
    {
        return ActionComponent::action($name, $callback);
    }
}

if (! function_exists('fi_form_field')) {
    /**
     * @param  string  $name
     * @param  Closure $callback
     * @return \Filament\Forms\Components\Field
     */
    function fi_form_field(string $name, Closure $callback) : \Filament\Forms\Components\Field
    {
        return FormComponent::input($name, $callback);
    }
}
