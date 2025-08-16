<?php

namespace App\Unit\Filament\Resources\UnitResource\Actions\Forms;

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
                    $input->required()->placeholder('Kilogram');
                }),

                fi_form_field('symbol', static function (TextInput $input) {
                    $input->required()->placeholder('kg')->label('Alias');
                }),
            ]),
        ];
    }
}
