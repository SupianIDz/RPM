<?php

namespace App\Brand\Filament\Components\Filters;

use App\Brand\Models\Brand;
use Filament\Tables\Filters\SelectFilter;
use Illuminate\Contracts\Database\Eloquent\Builder;

class BrandFilter extends SelectFilter
{
    protected function setUp() : void
    {
        parent::setUp();

        $this
            ->name('brand')
            ->label('Brand')
            ->searchable()
            ->options(function () {
                return Brand::active()->pluck('name', 'slug');
            });

        $this->query(function ($query, array $data) {
            $query->when(filled($data['value']), function (Builder $query) use ($data) {
                $query->whereRelation('brand', 'slug', $data['value']);
            });
        });
    }
}
