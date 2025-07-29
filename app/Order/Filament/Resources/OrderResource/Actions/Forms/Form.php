<?php

namespace App\Order\Filament\Resources\OrderResource\Actions\Forms;

use App\Customer\Models\Customer;
use App\Order\Enums\Payment;
use App\Vehicle\Enums\Brand;
use App\Vehicle\Models\Vehicle;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;

class Form
{
    /**
     * @param  mixed $action
     * @return array
     */
    public function configure(mixed $action) : array
    {
        return [
            Grid::make(2)->schema([
                fi_form_field('invoice', function (TextInput $input) {
                    $input->default(str_invoice(4));
                }),

                fi_form_field('customer', function (TextInput $input) {
                    $input->default(str_invoice(4));
                }),

                fi_form_field('payment', function (Select $input) {
                    $input->options(Payment::class)->default(Payment::CASH);
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
                        ->createOptionForm($this->vehicleForm())
                        ->createOptionUsing(function (array $data) {
                            return Vehicle::updateOrCreate(['plate' => $data['plate']], $data);
                        });

                    $input->helperText('Click the + button on the side if the plate is not listed');
                }),


            ]),
        ];
    }

    /**
     * @return array
     */
    private function vehicleForm() : array
    {
        return [
            Grid::make(2)->schema([
                fi_form_field('plate', function (TextInput $input) {
                    $input->required()->columnSpanFull()->placeholder('DA1234AG');
                }),

                fi_form_field('brand', function (Select $input) {
                    $input->options(Brand::class);
                }),

                fi_form_field('model', function (TextInput $input) {
                    $input->placeholder('Beat FI');
                }),
            ]),
        ];
    }

    private function customerForm() : array
    {
        return [
            Grid::make(2)->schema([
                fi_form_field('name', function (TextInput $input) {
                    $input->required()->placeholder('Full Name');
                }),

                fi_form_field('phone', function (TextInput $input) {
                    $input->placeholder('No. HP/WA');
                }),
            ]),
        ];
    }
}
