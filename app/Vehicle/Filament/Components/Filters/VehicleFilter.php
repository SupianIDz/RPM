<?php

namespace App\Vehicle\Filament\Components\Filters;

use App\Vehicle\Models\Vehicle;
use Filament\Forms\Components\Select;
use Filament\Forms\Get;
use Filament\Tables\Filters\Filter;
use Illuminate\Contracts\Database\Eloquent\Builder;

class VehicleFilter extends Filter
{
    /**
     * @return void
     */
    protected function setUp() : void
    {
        parent::setUp();

        $this->name('vehicle');

        $this->form([
            // fi_form_field('brand', static function (Select $select) {
            //     $select->options(function () {
            //         return Vehicle::distinct('brand')->pluck('brand', 'brand');
            //     });
            // }),

            // fi_form_field('model', static function (Select $select) {
            //     $select->options(function (Get $get) {
            //         if ($get('brand')) {
            //             return Vehicle::where('brand', $get('brand'))->pluck('model', 'model');
            //         }

            //         return Vehicle::pluck('model', 'model');
            //     });
            // }),

            fi_form_field('plate', static function (Select $select) {
                $select->options(function (Get $get) {
                    if ($get('brand')) {
                        return Vehicle::where('brand', $get('brand'))->pluck('plate', 'plate');
                    }

                    if ($get('model')) {
                        return Vehicle::where('model', $get('model'))->pluck('plate', 'plate');
                    }

                    return Vehicle::pluck('plate', 'plate');
                });
            }),
        ]);

        $this->modifyQueryUsing(function (Builder $query, array $data) {
            // $query->when(filled($data['brand']), fn(Builder $query) => $query->whereRelation('vehicle', 'brand', $data['brand']));
            // $query->when(filled($data['model']), fn(Builder $query) => $query->whereRelation('vehicle', 'model', $data['model']));
            $query->when(filled($data['plate']), fn(Builder $query) => $query->whereRelation('vehicle', 'plate', $data['plate']));
        });
    }
}
