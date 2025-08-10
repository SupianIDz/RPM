<?php

namespace App\Order\Filament\Resources\OrderResource\Pages;

use App\Order\Filament\Components\Filters\PaymentFilter;
use App\Order\Filament\Resources\OrderResource;
use App\Order\Filament\Resources\OrderResource\Actions\CreateAction;
use App\Order\Filament\Resources\OrderResource\Actions\DetailAction;
use App\Order\Filament\Resources\OrderResource\Actions\ModifyAction;
use App\Order\Filament\Resources\OrderResource\Actions\ReceiptAction;
use App\Support\Filament\Tables\Actions\DeleteAction;
use App\Vehicle\Filament\Components\Filters\VehicleFilter;
use App\Vehicle\Filament\Components\Filters\VehiclePlatFilter;
use Filament\Resources\Pages\ListRecords;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Malzariey\FilamentDaterangepickerFilter\Filters\DateRangeFilter;
use Override;

class ListOrders extends ListRecords
{
    protected static string $resource = OrderResource::class;

    /**
     * @return \class-string[]
     */
    #[Override]
    protected function getHeaderWidgets() : array
    {
        return [
            OrderResource\Widgets\OrderStatsOverview::class,
        ];
    }

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

                fi_ta_column('discount', static function (TextColumn $column) {
                    $column->rupiah()->searchable(false);
                }),

                fi_ta_column('payment', static function (TextColumn $column) {
                    $column->badge();
                }),
                fi_ta_column('date', function (TextColumn $column) {
                   $column->label('Trx Date')->date();
                }),

                fi_ta_column('creator.name', static function (TextColumn $column) {
                    $column->toggledHiddenByDefault(true);
                }),

                fi_ta_column('created_at', function (TextColumn $column) {
                    $column->toggledHiddenByDefault(true);
                }),
            ]);

        $table
            ->filters([
                fi_ta_filter(function (DateRangeFilter $filter) {
                    //
                }, 'date'),

                fi_ta_filter(function (PaymentFilter $filter) {
                    //
                }),

                fi_ta_filter(function (VehicleFilter $filter) {
                    //
                }),
            ]);

        $table
            ->actions([
                fi_action(function (DetailAction $action) {
                    //
                }),

                fi_action(function (ReceiptAction $action) {
                    //
                }),

                fi_action(function (ModifyAction $action) {
                    //
                }),

                fi_action(function (DeleteAction $action) {
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
        return $table->modifyQueryUsing(function ($query) {
            $query->with('customer');
        });
    }
}
