<?php

namespace App\Order\Filament\Resources\OrderResource\Pages;

use App\Order\Filament\Resources\OrderResource;
use App\Order\Filament\Resources\OrderResource\Actions\CreateAction;
use App\Order\Filament\Resources\OrderResource\Actions\ModifyAction;
use App\Support\Filament\Tables\Actions\DeleteAction;
use Filament\Resources\Pages\ListRecords;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class ListOrders extends ListRecords
{
    protected static string $resource = OrderResource::class;

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

    /**
     * @param  Table $table
     * @return Table
     */
    public function table(Table $table) : Table
    {
        $table
            ->columns([
                fi_ta_column('invoice', function (TextColumn $column) {
                    //
                }),

                fi_ta_column('customer.name', function (TextColumn $column) {
                    //
                }),

                fi_ta_column('vehicle.brand', static function (TextColumn $column) {
                    $column->formatStateUsing(function (string $state, $record) {
                        return $record->vehicle->brand . ' ' . $record->vehicle->model;
                    });
                }),

                fi_ta_column('vehicle.plate', static function (TextColumn $column) {
                    $column->label('Plate Number')->badge();
                }),

                fi_ta_column('total', static function (TextColumn $column) {
                    $column->rupiah()->searchable(false);
                }),

                fi_ta_column('payment', function (TextColumn $column) {
                    //
                }),

                fi_ta_column('creator.name', function (TextColumn $column) {
                   //
                }),

                fi_ta_column('created_at', function (TextColumn $column) {
                    //
                }),
            ]);

        $table->actions([
            fi_action(function (ModifyAction $action) {
                //
            }),

            fi_action(function (DeleteAction $action){

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
        return $table->modifyQueryUsing(function ($query) {
            $query->with('customer');
        });
    }
}
