<?php

namespace App\Order\Filament\Resources\OrderResource\Actions\Forms;

use App\Order\Enums\Payment;
use App\Order\Enums\Type;
use App\Vehicle\Enums\Brand;
use App\Vehicle\Models\Vehicle;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Wizard;

class Form
{
    /**
     * @param  mixed $action
     * @return array
     */
    public function configure(mixed $action) : array
    {
        return [
            Wizard::make([
                Wizard\Step::make('Transaction Items')->schema([
                    Repeater::make('items')->schema($this->trxSchema()),
                ]),

                Wizard\Step::make('Transaction Info')->schema([
                    Grid::make(2)->schema([

                        fi_form_field('invoice', static function (TextInput $input) {
                            $input->label('Invoice Number')->default(str_invoice(4));
                            $input->required();
                        }),

                        fi_form_field('payment', static function (Select $input) {
                            $input->options(Payment::class)->default(Payment::CASH);
                            $input->required();
                        }),

                        fi_form_field('name', static function (TextInput $input) {
                            $input->placeholder('Full Name');
                        }),

                        fi_form_field('phone', static function (TextInput $input) {
                            $input->placeholder('No. HP/WA');
                        }),

                        fi_form_field('vehicle_id', function (Select $input) {
                            $input->label('Plate Number');
                            $input->options(function () {
                                return Vehicle::get()->flatMap(function (Vehicle $vehicle) {
                                    return [
                                        $vehicle->id => $vehicle->plate . ' - ' . $vehicle->brand . ' ' . $vehicle->model,
                                    ];
                                });
                            });

                            $input
                                ->createOptionForm($this->vehicleSchema())
                                ->createOptionUsing(function (array $data) {
                                    return Vehicle::updateOrCreate(['plate' => $data['plate']], $data);
                                });

                            $input
                                ->helperText('Click the + button on the side if the plate is not listed')
                                ->columnSpanFull();
                        }),

                    ]),
                ]),
            ]),
        ];
    }

    /**
     * @return array
     */
    private function vehicleSchema() : array
    {
        return [
            Grid::make(2)->schema([
                fi_form_field('plate', static function (TextInput $input) {
                    $input->required()->columnSpanFull()->placeholder('DA1234AG');
                }),

                fi_form_field('brand', static function (Select $input) {
                    $input->options(Brand::class);
                }),

                fi_form_field('model', static function (TextInput $input) {
                    $input->placeholder('Beat FI');
                }),
            ]),
        ];
    }

    /**
     * @return array
     */
    private function trxSchema() : array
    {
        return [
            Grid::make(2)->schema([
                fi_form_field('type', function (Select $input) {
                    $input->options(Type::class)->default(Type::PRODUCT);
                }),
            ]),
        ];
    }
}
