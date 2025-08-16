<?php

namespace App\Unit\Filament\Resources\UnitResource\Actions;

use Filament\Support\Enums\MaxWidth;

class CreateAction extends \App\Support\Filament\Actions\CreateAction
{
    /**
     * @return void
     */
    protected function setUp() : void
    {
        parent::setUp();

        $this
            ->modalWidth(MaxWidth::TwoExtraLarge)
            ->form(new Forms\Form()->configure())
            ->mutateFormDataUsing(function ($data) {
                return array_merge($data, [
                    'created_by' => auth()->id(),
                ]);
            });
    }
}
