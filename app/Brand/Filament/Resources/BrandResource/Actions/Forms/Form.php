<?php

namespace App\Brand\Filament\Resources\BrandResource\Actions\Forms;

use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\TextInput;

class Form
{
    /**
     * @return array
     */
    public function configure() : array
    {
        return [
            Grid::make(2)->schema([
                fi_form_field('name', static function (TextInput $input) {
                    $input
                        ->placeholder('Brand Name')
                        ->required();
                }),

                fi_form_field('site', static function (TextInput $input) {
                    $input->placeholder('https://example.com');
                }),

                fi_form_field('logo', static function (FileUpload $input) {
                    $input
                        ->image()
                        ->disk('brand:logo');

                    $input->columnSpanFull();
                }),
            ]),
        ];
    }
}
