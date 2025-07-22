<?php

namespace App\Category\Filament\Components;

use App\Category\Models\Category;
use Filament\Tables\Filters\SelectFilter;
use Illuminate\Contracts\Database\Eloquent\Builder;

class CategoryFilter extends SelectFilter
{
    protected function setUp() : void
    {
        parent::setUp();

        $this
            ->name('category')
            ->label('Category')
            ->searchable()
            ->options(function () {
                return Category::pluck('name', 'slug');
            });

        $this->query(function ($query, array $data) {
            $query->when(filled($data['value']), function (Builder $query) use ($data) {
                $query->whereRelation('category', 'slug', $data['value']);
            });
        });
    }
}
