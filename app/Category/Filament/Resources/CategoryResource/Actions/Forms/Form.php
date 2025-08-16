<?php

namespace App\Category\Filament\Resources\CategoryResource\Actions\Forms;

use Filament\Forms\Components\TextInput;
use Filament\Tables\Columns\TextColumn;

class Form
{
    public function configure() : array
    {
        return [
            fi_form_field('name', static function (TextInput $input) {
                $input->required();
            }),
        ];
    }
}
