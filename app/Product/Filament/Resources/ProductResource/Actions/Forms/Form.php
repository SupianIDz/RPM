<?php

namespace App\Product\Filament\Resources\ProductResource\Actions\Forms;

use App\Brand\Filament\Components\Forms\BrandSelect;
use App\Category\Filament\Components\CategorySelect;
use App\Product\Filament\Resources\ProductResource\Actions\CreateAction;
use App\Unit\Filament\Components\Forms\UnitSelect;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;

class Form
{
    /**
     * @param  CreateAction $action
     * @return array
     */
    public function configure(CreateAction $action) : array
    {
        return [
            Grid::make(2)->schema([
                fi_form_field('name', static function (TextInput $input) {
                    $input->required();
                }),

                fi_form_field('amount', static function (TextInput $input) {
                    $input->required()->numeric()->default(0);
                    $input->prefix('Rp');
                }),

                fi_form_field('description', static function (Textarea $input) {
                    $input->columnSpanFull();
                }),

                fi_form_field('brand_id', function (BrandSelect $input) {
                    //
                }),

                fi_form_field('category_id', function (CategorySelect $input) {
                    //
                }),

                fi_form_field('stock', static function (TextInput $input) {
                    $input->required()->numeric()->default(0);
                }),

                fi_form_field('unit_id', function (UnitSelect $input) {
                    //
                }),

                fi_form_field('image', static function (FileUpload $input) {
                    $input
                        ->image()
                        ->imageEditor();

                    $input->disk('product:image');

                    $input->columnSpanFull();
                }),
            ]),
        ];
    }
}
