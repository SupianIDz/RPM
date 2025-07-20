<?php

namespace App\Product\Filament\Resources\ProductResource\Pages;

use App\Brand\Filament\Components\Filters\BrandFilter;
use App\Product\Filament\Resources\ProductResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Enums\FiltersLayout;
use Filament\Tables\Table;
use Illuminate\Contracts\Database\Eloquent\Builder;

class ListProducts extends ListRecords
{
    protected static string $resource = ProductResource::class;

    protected function getHeaderActions() : array
    {
        return [
            CreateAction::make(),
        ];
    }

    public function table(Table $table) : Table
    {
        $table
            ->columns([
                fi_ta_column('logo_url', static function (ImageColumn $column) {
                    $column->size(40)->defaultImageUrl(asset('images/no-image.svg'));
                }),

                fi_ta_column('name', static function (TextColumn $column) {
                    //
                }),

                fi_ta_column('brand.name', static function (TextColumn $column) {
                    //
                }),

                fi_ta_column('category.name', static function (TextColumn $column) {
                    //
                }),

            ]);

        $table
            ->filters([
                fi_ta_filter(function (BrandFilter $filter) {
                    //
                }),
            ]);

        return $this->modifyQueryUsing($table);
    }

    /**
     * @param  Table $table
     * @return Table
     */
    private function modifyQueryUsing(Table $table) : Table
    {
        return
            $table->modifyQueryUsing(function (Builder $query) {
            });
    }
}
