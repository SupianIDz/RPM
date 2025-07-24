<?php

namespace App\Product\Filament\Resources\ProductResource\Actions;

use App\Product\Models\Product;

class CreateAction extends \App\Support\Filament\Actions\CreateAction
{
    /**
     * @return void
     */
    protected function setUp() : void
    {
        parent::setUp();

        $this
            ->form(
                new Forms\Form()->configure($this),
            );

        $this
            ->mutateFormDataUsing(function (array $data) {
                return array_merge($data, [
                    'created_by' => auth()->id(),
                ]);
            });
    }
}
