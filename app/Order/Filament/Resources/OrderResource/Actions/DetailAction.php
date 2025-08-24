<?php

namespace App\Order\Filament\Resources\OrderResource\Actions;

use App\Order\Models\Order;
use Filament\Infolists\Components\Grid;
use Filament\Infolists\Components\Section;
use Filament\Infolists\Components\TextEntry;
use Filament\Infolists\Components\ViewEntry;
use Filament\Support\Enums\MaxWidth;

class DetailAction extends \App\Support\Filament\Tables\Actions\DetailAction
{
    /**
     * @return void
     */
    protected function setUp() : void
    {
        parent::setUp();

        $this
            ->modalWidth(MaxWidth::SixExtraLarge)
            ->infolist([
                Section::make('Order Information')
                    ->collapsible()
                    ->schema([
                        Grid::make(2)->schema([
                            fi_entry('invoice', static function (TextEntry $entry) {
                                $entry->extraAttributes(['class' => 'font-bold']);
                            }),

                            fi_entry('date', static function (TextEntry $entry) {
                                $entry->dateTime();
                            }),

                            fi_entry('customer.name', function (TextEntry $entry) {
                                $entry
                                    ->hidden(function (Order $record) {
                                        return blank($record->customer);
                                    })
                                    ->helperText(function (Order $record) {
                                        return $record->customer->phone;
                                    });
                            }),

                            fi_entry('vehicle.plate', static function (TextEntry $entry) {
                                $entry
                                    ->hidden(function (Order $record) {
                                        return blank($record->vehicle);
                                    })
                                    ->formatStateUsing(function (string $state, $record) {
                                        return $state . ' - ' . $record->vehicle->brand . ' ' . $record->vehicle->model;
                                    });
                            }),
                        ]),
                    ]),

                fi_entry('items', static function (ViewEntry $entry) {
                    $entry->view('orders.detail.items')->viewData(function (Order $record) {
                        return compact('record');
                    });
                }),
            ])
            ->extraModalFooterActions([
                fi_action(function (ReceiptAction $action) {
                    $action->hiddenLabel(false)->label('Print Receipt')->button();
                }),
            ]);
    }
}
