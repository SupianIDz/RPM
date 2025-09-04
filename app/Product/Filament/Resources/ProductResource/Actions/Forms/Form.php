<?php

namespace App\Product\Filament\Resources\ProductResource\Actions\Forms;

use App\Brand\Filament\Components\Forms\BrandSelect;
use App\Category\Filament\Components\CategorySelect;
use App\Product\Filament\Resources\ProductResource\Actions\CreateAction;
use App\Product\Filament\Resources\ProductResource\Actions\ModifyAction;
use App\Unit\Filament\Components\Forms\UnitSelect;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Group;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;

/**
 * @template TAction of CreateAction|ModifyAction
 */
class Form
{
    /**
     * @param  TAction $action
     * @return array
     */
    public function configure($action) : array
    {
        return [
            Grid::make(2)->schema([
                fi_form_field('name', static function (TextInput $input) {
                    $input->required()->label('Nama')->placeholder('V Belt Aerox 155')->columnSpanFull();
                }),

                Group::make()
                    ->columnSpanFull()
                    ->relationship('price')->schema([
                        Grid::make(2)->schema([
                            fi_form_field('cogs', static function (TextInput $input) {
                                $input->label('Harga Beli / Modal');
                                $input->required()->numeric()->default(0)->minValue(0);
                                $input->prefix('Rp');
                            }),

                            fi_form_field('amount', static function (TextInput $input) {
                                $input->label('Harga Jual')->required()->numeric()->default(0)->minValue(0);
                                $input->prefix('Rp');
                            }),
                        ]),
                    ]),

                fi_form_field('description', static function (Textarea $input) {
                    $input->columnSpanFull()->placeholder('Deskripsi');
                }),

                fi_form_field('stock', static function (TextInput $input) {
                    $input->required()->numeric()->default(0)->minValue(0);

                    $input->disabled(function () {
                        return ! user()->permission->admin();
                    });

                    $input->helperText('Hanya role admin yang dapat mengubah stok.');
                }),

                fi_form_field('unit_id', function (UnitSelect $input) {
                    $input->label('Satuan')->required();
                }),

                fi_form_field('brand_id', function (BrandSelect $input) {
                    $input->label('Merek');
                }),

                fi_form_field('category_id', function (CategorySelect $input) {
                    $input->label('Kategori');
                }),

                Group::make()->relationship('image', condition: fn(?array $state) : bool => filled($state['name']))->columnSpanFull()->schema([
                    fi_form_field('name', static function (FileUpload $input) {
                        $input
                            ->label('Gambar')
                            ->image()
                            ->imageEditor();

                        $input->disk('product:image');
                    }),
                ]),
            ]),
        ];
    }
}
