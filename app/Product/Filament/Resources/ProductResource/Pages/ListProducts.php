<?php

namespace App\Product\Filament\Resources\ProductResource\Pages;

use App\Brand\Filament\Components\Filters\BrandFilter;
use App\Category\Filament\Components\CategoryFilter;
use App\Product\Filament\Resources\ProductResource;
use App\Product\Filament\Resources\ProductResource\Actions\CreateAction;
use App\Product\Filament\Resources\ProductResource\Actions\ModifyAction;
use App\Product\Filament\Resources\ProductResource\Widgets\ProductOverview;
use App\Product\Models\Product;
use App\Support\Filament\Tables\Actions\Bulks;
use App\Support\Filament\Tables\Actions\DeleteAction;
use App\Support\Filament\Tables\Actions\ForceDeleteAction;
use App\Support\Filament\Tables\Actions\RestoreAction;
use Filament\Actions\Action;
use Filament\Actions\ActionGroup;
use Filament\Resources\Pages\ListRecords;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\TrashedFilter;
use Filament\Tables\Table;
use Illuminate\Contracts\Database\Eloquent\Builder;
use Illuminate\Support\HtmlString;

class ListProducts extends ListRecords
{
    protected static string $resource = ProductResource::class;

    /**
     * @return class-string[]
     */
    protected function getHeaderWidgets() : array
    {
        return [
            ProductOverview::class,
        ];
    }

    /**
     * @return Action[]|ActionGroup[]
     */
    protected function getHeaderActions() : array
    {
        return [
            fi_action(function (CreateAction $action) {
                //
            }),
        ];
    }

    /**
     * @param  Table $table
     * @return Table
     */
    public function table(Table $table) : Table
    {
        $table
            ->columns([
                fi_ta_column('image.name', static function (ImageColumn $column) {
                    $column->disk('product:image');
                }),

                fi_ta_column('name', static function (TextColumn $column) {
                    $column->description(function (Product $record) {
                        return new HtmlString('<span class="text-xs text-warning-600">' . $record->code . '</span>');
                    });
                }),

                fi_ta_column('price.amount', static function (TextColumn $column) {
                    $column->rupiah();
                }),

                fi_ta_column('brand.name', static function (TextColumn $column) {
                    //
                }),

                fi_ta_column('category.name', static function (TextColumn $column) {
                    //
                }),

                fi_ta_column('creator.name', static function (TextColumn $column) {
                    $column->default('System');
                }),

                fi_ta_column('created_at', static function (TextColumn $column) {
                    $column->date();
                }),

            ]);

        $table
            ->filters([
                fi_ta_filter(static function (CategoryFilter $filter) {
                    //
                }),

                fi_ta_filter(static function (BrandFilter $filter) {
                    //
                }),

                fi_ta_filter(static function (TrashedFilter $filter) {
                    $filter->searchable();
                }, 'trashed'),
            ]);

        $table
            ->bulkActions([
                fi_action(function (Bulks\DeleteAction $action) {
                    //
                }),
                fi_action(function (Bulks\RestoreAction $action) {
                    //
                }),
            ])
            ->actions([
                fi_action(function (ModifyAction $action) {
                    //
                }),

                fi_action(function (RestoreAction $action) {
                    //
                }),

                fi_action(function (DeleteAction $action) {
                    //
                }),

                fi_action(function (ForceDeleteAction $action) {
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
