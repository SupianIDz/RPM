<?php

namespace App\Order\Filament\Resources\OrderResource\Actions\Forms;

use App\Order\Enums\Payment;
use App\Order\Enums\Type;
use App\Product\Models\Product;
use App\Vehicle\Enums\Brand;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Group;
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
                Wizard\Step::make('Sparepart')->schema($this->productSchema()),

                Wizard\Step::make('Biaya Service dan Lainnya')->schema($this->serviceSchema()),

                Wizard\Step::make('Informasi Transaksi')->schema([
                    Grid::make(2)->schema([

                        fi_form_field('invoice', static function (TextInput $input) {
                            $input->label('Nomor Transaksi')->default(str_invoice(4));
                            $input->required();

                            $input
                                ->helperText('Nomor transaksi akan dibuat otomatis, tetapi Anda dapat menambahkan manual jika diperlukan. Harap hati-hati untuk menghindari duplikasi.');
                        }),

                        fi_form_field('date', function (DateTimePicker $input) {
                            $input
                                ->label('Tanggal Transaksi')
                                ->native(false)->default(now())->required();

                            $input->helperText('You can enter a past date for the transaction if necessary.');
                        }),

                        fi_form_field('discount', function (TextInput $input) {
                            $input
                                ->label('Diskon')
                                ->prefix('Rp')
                                ->helperText('Masukkan diskon jika ada.')
                                ->numeric()->default(0);
                        }),

                        fi_form_field('payment', static function (Select $input) {
                            $input
                                ->label('Metode Pembayaran')
                                ->options(Payment::class)->default(Payment::CASH);
                            $input->required();
                        }),

                        Group::make([
                            Grid::make(2)->schema([
                                fi_form_field('name', static function (TextInput $input) {
                                    $input
                                        ->label('Nama Konsumen')
                                        ->placeholder('Full Name');

                                    $input->helperText('Abaikan bila tidak ada.');
                                }),

                                fi_form_field('phone', static function (TextInput $input) {
                                    $input->placeholder('No. HP/WA Konsumen')->reactive();
                                    $input->helperText('Abaikan bila tidak ada.');
                                }),
                            ]),
                        ])
                            ->columnSpanFull()
                            ->relationship('customer', condition: fn(?array $state) => filled($state['name'])),

                        fi_form_field('plate', function (TextInput $input) {
                            $input
                                ->label('Nomor Polisi')
                                ->placeholder('DA1234AG');

                            $input
                                ->helperText('Abaikan bila tidak ada.')
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
                ->relationship()
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
                                ->label('Produk / Sparepart')
                                ->options(function (Get $get) {
                                    return Product::get()->flatMap(function (Product $product) use ($get) {
                                        $name = $product->name;
                                        if ($product->brand) {
                                            $name = $product->brand->name . ' - ' . $name;
                                        }

                                        return [
                                            $product->id => $name,
                                        ];
                                    });
                                })
                                ->afterStateUpdated(function (Set $set, $state) {
                                    if ($state) {
                                        $product = Product::find($state);
                                        $set('cogs', $product->price->cogs);
                                        $set('amount', $product->price->amount);
                                    }
                                });

                            $input
                                ->required()
                                ->reactive()
                                ->columnSpan(3);
                        }),

                        fi_form_field('cogs', static function (TextInput $input) {
                            $input
                                ->label('Modal')
                                ->prefix('Rp')->readOnly();
                        }),

                        fi_form_field('amount', static function (TextInput $input) {
                            $input
                                ->label('Harga')
                                ->prefix('Rp')->readOnly();
                        }),

                        fi_form_field('quantity', static function (TextInput $input) {
                            $input
                                ->label('Jumlah')
                                ->required()->numeric()->default(1);
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
                ->relationship()
                ->mutateRelationshipDataBeforeCreateUsing(function (array $data) {
                    return array_merge($data, [
                        'name' => match ($data['type']) {
                            'SERVICE'          => 'Service',
                            'TURNING'          => 'Bubut',
                            'BENZENE'          => 'Bensol',
                            'PRODUCT', 'OTHER' => $data['name'],
                        },
                    ]);
                })
                ->hiddenLabel()
                ->collapsible()
                ->defaultItems(0)
                ->addActionLabel('Tambah Item')
                ->schema([
                    Grid::make(6)->schema([
                        fi_form_field('type', static function (Select $input) {
                            $input
                                ->label('Jenis')
                                ->options([
                                    'TURNING' => 'BUBUT',
                                    'BENZENE' => 'BENSOL',
                                    'SERVICE' => 'SERVICE',
                                    'PRODUCT' => 'SPAREPART',
                                    // 'OTHER'   => 'LAINNYA',
                                ])
                                ->default('SERVICE');

                            $input
                                ->reactive()
                                ->required();

                            $input;
                        }),

                        fi_form_field('name', static function (TextInput $input) {
                            $input
                                ->label('Nama')
                                ->required();

                            $input
                                ->hidden(function (Get $get) {
                                    return $get('type') !== 'OTHER' && $get('type') !== 'PRODUCT';
                                })
                                ->columnSpan(2);
                        }),

                        fi_form_field('cogs', static function (TextInput $input) {
                            $input->label('Modal')->prefix('Rp');

                            $input
                                ->required()->numeric()
                                ->hidden(function (Get $get) {
                                    $type = $get('type');
                                    if ($type === 'BENZENE' || $type === 'PRODUCT' || $type === 'OTHER') {
                                        return false;
                                    }

                                    return true;
                                });

                            $input->columnSpan(function (Get $get) {
                                if ($get('type') === 'BENZENE') {
                                    return 2;
                                }
                            });

                            $input
                                ->reactive();
                        }),

                        fi_form_field('amount', static function (TextInput $input) {
                            $input->label('Harga')->prefix('Rp');

                            $input->required()->numeric();
                            $input->columnSpan(function (Get $get) {
                                if ($get('type') === 'BENZENE') {
                                    return 2;
                                }

                                return $get('type') === 'OTHER' || $get('type') === 'PRODUCT' ? 1 : 4;
                            });

                            $input
                                ->reactive();
                        }),

                        fi_form_field('quantity', static function (TextInput $input) {
                            $input
                                ->label('Jumlah')
                                ->numeric()->default(1);
                            $input
                                ->reactive()
                                ->required();
                        }),
                    ]),
                ]),
        ];
    }
}
