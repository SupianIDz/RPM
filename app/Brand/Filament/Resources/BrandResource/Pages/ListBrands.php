<?php

namespace App\Brand\Filament\Resources\BrandResource\Pages;

use App\Brand\Filament\Resources\BrandResource;
use App\Brand\Filament\Resources\BrandResource\Actions\CreateAction;
use App\Brand\Filament\Resources\BrandResource\Actions\ModifyAction;
use Filament\Actions\Action;
use Filament\Actions\ActionGroup;
use Filament\Resources\Pages\ListRecords;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Contracts\Database\Eloquent\Builder;

class ListBrands extends ListRecords
{
    protected static string $resource = BrandResource::class;

    /**
     * @return array
     */
    protected function getHeaderActions() : array
    {
        return [
            fi_action(function (CreateAction $action) {
                //
            }),
        ];
    }

    public function table(Table $table) : Table
    {
        $table
            ->columns([
                fi_ta_column('logo_url', static function (ImageColumn $column) {
                    $column->size(40);
                }),

                fi_ta_column('name', static function (TextColumn $column) {
                    //
                }),

                fi_ta_column('site', static function (TextColumn $column) {
                    $column->label('Website');
                }),

                fi_ta_column('creator.name', static function (TextColumn $column) {
                    $column->default('System');
                }),

                fi_ta_column('created_at', static function (TextColumn $column) {
                    //
                }),

                fi_ta_column('updated_at', static function (TextColumn $column) {
                    //
                }),
            ]);

        $table->actions([
           fi_action(function (ModifyAction $action){
               //
           })
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
                //
            });
    }
}
