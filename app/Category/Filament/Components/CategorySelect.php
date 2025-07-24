<?php

namespace App\Category\Filament\Components;

use App\Category\Models\Category;
use Filament\Forms\Components\Select;

class CategorySelect extends Select
{
    /**
     * @return void
     */
    protected function setUp() : void
    {
        parent::setUp();

        $this
            ->name('category_id')
            ->label('Category')
            ->placeholder('Select a category')
            ->options(function () {
                return Category::pluck('name', 'id');
            });

        $this->searchable();
    }
}
