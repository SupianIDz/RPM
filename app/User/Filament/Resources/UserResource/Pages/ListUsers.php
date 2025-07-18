<?php

namespace App\User\Filament\Resources\UserResource\Pages;

use App\User\Filament\Resources\UserResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Contracts\Database\Eloquent\Builder;

class ListUsers extends ListRecords
{
    protected static string $resource = UserResource::class;

    protected function getHeaderActions() : array
    {
        return [
            CreateAction::make(),
        ];
    }

    /**
     * @param  Table $table
     * @return Table
     */
    public function table(Table $table) : Table
    {
        $table
            ->columns([
                fi_ta_column('name', static function (TextColumn $column) {
                    $column->label('Nama');
                }),

                fi_ta_column('email', static function (TextColumn $column) {
                    $column->label('Email');
                }),

                fi_ta_column('roles.name', static function (TextColumn $column) {
                    $column->label('Role')->badge();
                }),
            ]);

        return $this->modifyQueryUsing($table);
    }

    /**
     * @param  Table $table
     * @return Table
     */
    private function modifyQueryUsing(Table $table) : Table
    {
        return
            $table->modifyQueryUsing(function (Builder $query) {
                $query->with([
                    'roles' => function (Builder $query) {
                        $query->withCasts([
                            'name' => \App\User\Enums\Role::class,
                        ]);
                    },
                ]);
            });
    }
}
