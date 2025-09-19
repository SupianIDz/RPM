<?php

namespace App\Order\Filament\Resources\OrderResource\Pages;

use App\Order\Filament\Components\Filters\PaymentFilter;
use App\Order\Filament\Resources\OrderResource;
use App\Order\Filament\Resources\OrderResource\Actions\CreateAction;
use App\Order\Filament\Resources\OrderResource\Actions\DetailAction;
use App\Order\Filament\Resources\OrderResource\Actions\ModifyAction;
use App\Order\Filament\Resources\OrderResource\Actions\ReceiptAction;
use App\Recap\Filament\Actions\ExportAction;
use App\Support\Filament\Tables\Actions\DeleteAction;
use App\Vehicle\Filament\Components\Filters\VehicleFilter;
use App\Vehicle\Filament\Components\Filters\VehiclePlatFilter;
use Filament\Resources\Pages\ListRecords;
use Filament\Support\Enums\FontWeight;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Malzariey\FilamentDaterangepickerFilter\Filters\DateRangeFilter;
use Override;

class ListOrders extends ListRecords
{
    protected static string $resource = OrderResource::class;

    /**
     * @return class-string[]
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
                $action->label('Tambah Transaksi');
            }),

            fi_action(static function (ExportAction $action) {
                $action->route('exports.order');
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
                    $column->weight(FontWeight::Bold);
                }),

                fi_ta_column('customer.name', function (TextColumn $column) {
                    $column->label('Nama Konsumen');
                }),

                // fi_ta_column('vehicle.brand', static function (TextColumn $column) {
                //     $column->formatStateUsing(function (string $state, $record) {
                //         return $record->vehicle->brand . ' ' . $record->vehicle->model;
                //     });
                // }),

                fi_ta_column('vehicle.plate', static function (TextColumn $column) {
                    $column->label('Nomor Polisi')->badge();
                }),

                fi_ta_column('total', static function (TextColumn $column) {
                    $column->rupiah()->searchable(false);
                }),

                fi_ta_column('discount', static function (TextColumn $column) {
                    $column->rupiah()->searchable(false)->label('Diskon');;
                }),

                fi_ta_column('payments.type', static function (TextColumn $column) {
                    $column->badge()->label('Pembayaran');
                }),
                fi_ta_column('date', function (TextColumn $column) {
                    $column->label('Tgl. Transaksi')->date();
                }),

                fi_ta_column('creator.name', static function (TextColumn $column) {
                    $column->toggledHiddenByDefault(true)->label('Kasir');
                }),

                fi_ta_column('created_at', function (TextColumn $column) {
                    $column->toggledHiddenByDefault(true)->label('Dibuat Pada');
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
