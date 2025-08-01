<?php

namespace App\Order\Filament\Resources\OrderResource\Actions\Forms;

use App\Order\Enums\Payment;
use App\Order\Enums\Type;
use App\Product\Models\Product;
use App\Vehicle\Enums\Brand;
use App\Vehicle\Models\Vehicle;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Wizard;
use Filament\Forms\Get;
use Filament\Forms\Set;

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
                Wizard\Step::make('Products & Sparepart')->schema($this->productSchema()),

                Wizard\Step::make('Service Fee & Others')->schema($this->serviceSchema()),

                Wizard\Step::make('Order Information')->schema([
                    Grid::make(2)->schema([

                        fi_form_field('invoice', static function (TextInput $input) {
                            $input->label('Invoice Number')->default(str_invoice(4));
                            $input->required();
                        }),

                        fi_form_field('date', function (DateTimePicker $input) {
                            $input->native(false)->default(now())->required();
                        }),

                        fi_form_field('discount', function (TextInput $input) {
                            $input->numeric()->default(0);
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
    private function productSchema() : array
    {
        return [
            Repeater::make('products')
                ->relationship('items')
                ->mutateRelationshipDataBeforeCreateUsing(function (array $data) {
                    return array_merge($data, [
                        'type' => Type::PRODUCT,
                    ]);
                })
                ->hiddenLabel()
                ->collapsible()
                ->defaultItems(0)
                ->addActionLabel('Add Product')
                ->itemLabel(function (array $state) {
                    if (filled($state['product_id'])) {
                        $product = Product::find($state['product_id']);
                        $items = [];
                        if ($product->brand) {
                            $items[] = $product->brand->name;
                        }

                        $items[] = $product->name;

                        return implode(' - ', $items);
                    }

                    return null;
                })
                ->schema([
                    Grid::make(6)->schema([
                        // PRODUCT
                        fi_form_field('product_id', static function (Select $input) {
                            $input
                                ->label('Product')
                                ->options(function (Get $get) {
                                    return Product::get()->flatMap(function (Product $product) use ($get) {
                                        return [
                                            $product->id => $product->brand->name . ' - ' . $product->name,
                                        ];
                                    });
                                })
                                ->afterStateUpdated(function (Set $set, $state) {
                                    if ($state) {
                                        $set('amount', Product::find($state)->price->amount);
                                    }
                                });

                            $input
                                ->required()
                                ->reactive()
                                ->columnSpan(3);
                        }),

                        fi_form_field('amount', static function (TextInput $input) {
                            $input->prefix('Rp')->readOnly()->columnSpan(2);
                        }),

                        fi_form_field('quantity', static function (TextInput $input) {
                            $input->required()->numeric()->default(1);
                        }),
                    ]),
                ]),
        ];
    }

    /**
     * @return array
     */
    private function serviceSchema() : array
    {
        return [
            Repeater::make('services')
                ->relationship('items')
                ->mutateRelationshipDataBeforeCreateUsing(function (array $data) {
                    return array_merge($data, [
                        'name' => match ($data['type']) {
                            'SERVICE' => 'Service',
                            'TURNING' => 'Bubut',
                            'OTHER'   => $data['name'],
                        },
                    ]);
                })
                ->hiddenLabel()
                ->collapsible()
                ->defaultItems(0)
                ->addActionLabel('Add Service')
                ->schema([
                    Grid::make(6)->schema([
                        fi_form_field('type', static function (Select $input) {
                            $input
                                ->label('Type')
                                ->options([
                                    'SERVICE' => 'SERVICE',
                                    'TURNING' => 'TURNING',
                                    'OTHER'   => 'OTHER',
                                ])
                                ->default('SERVICE');

                            $input
                                ->reactive()
                                ->required();

                            $input->columnSpan(1);
                        }),

                        fi_form_field('name', static function (TextInput $input) {
                            $input->required();

                            $input
                                ->hidden(function (Get $get) {
                                    return $get('type') !== 'OTHER';
                                })
                                ->columnSpan(2);
                        }),

                        fi_form_field('amount', static function (TextInput $input) {
                            $input->label('Price')->prefix('Rp');

                            $input->required()->numeric();
                            $input->columnSpan(function (Get $get) {
                                return $get('type') === 'OTHER' ? 2 : 4;
                            });

                            $input
                                ->reactive();
                        }),

                        fi_form_field('quantity', static function (TextInput $input) {
                            $input->numeric()->default(1);
                            $input
                                ->reactive()
                                ->required();

                            $input->columnSpan(1);
                        }),
                    ]),
                ]),
        ];
    }
}
