<?php

namespace App\User\Filament\Resources\UserResource\Actions\Forms;

use App\User\Enums\Role;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;

class Form
{
    /**
     * @param  bool $edit
     * @return array
     */
    public function configure(bool $edit = false) : array
    {
        return [
            Grid::make(2)->schema([
                fi_form_field('name', static function (TextInput $input) {
                    $input->placeholder('Full Name')->required();
                }),

                fi_form_field('role', static function (Select $input) {
                    $input->options(Role::class)->required();
                }),

                fi_form_field('email', static function (TextInput $input) use ($edit) {
                    $input->email()->unique('users', 'email', ignoreRecord: $edit);

                    $input->required();
                }),

                fi_form_field('password', static function (TextInput $input) use ($edit) {
                    $input->password()->required(! $edit);

                    $input
                        ->dehydrateStateUsing(fn(string $state) : string => bcrypt($state))
                        ->dehydrated(fn(?string $state) : bool => filled($state));

                    if ($edit) {
                        $input->helperText('Leave blank if you don\'t want to change the password');
                    }
                }),

            ]),
        ];
    }
}
