<?php

namespace App\Recap\Filament\Resources\RecapDailyResource\Pages;

use App\Order\Models\OrderItem;
use App\Recap\Filament\Resources\RecapDailyResource;
use Filament\Resources\Pages\ViewRecord;
use Filament\Tables\Columns\Summarizers\Sum;
use Filament\Tables\Columns\Summarizers\Summarizer;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Concerns\InteractsWithTable;
use Filament\Tables\Contracts\HasTable;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder as EloquentBuilder;
use Illuminate\Database\Query\Builder;
use Illuminate\Support\Facades\DB;

/**
 * @method getRecord() : RecapDaily
 */
class DailySoldProduct extends ViewRecord implements HasTable
{
    use InteractsWithTable;

    protected static string $resource = RecapDailyResource::class;

    protected static string $view = 'vendor.filament.foo';

    /**
     * @param  Table $table
     * @return Table
     */
    public function table(Table $table) : Table
    {
        $table
            ->query($this->query())
            ->columns([
                fi_ta_column('invoice', function (TextColumn $column) {
                }),

                fi_ta_column('name', function (TextColumn $column) {
                    //
                }),

                fi_ta_column('quantity', static function (TextColumn $column) {
                    $column->label('QTY')->sortable(false)->summarize([
                        Sum::make()->label('')->formatStateUsing(function ($state) {
                            return number($state)->format();
                        }),
                    ]);
                }),

                fi_ta_column('product_total', static function (TextColumn $column) {
                    $column->rupiah()->label('Spare part')->sortable(false);

                    $column->summarize([
                        Summarizer::make()
                            ->formatStateUsing(function ($state) {
                                return str($state)->rupiah();
                            })
                            ->using(function (Builder $query) {
                                return $query->sum(DB::raw("CASE WHEN type = 'PRODUCT' THEN amount ELSE 0 END"));
                            }),
                    ]);
                }),

                fi_ta_column('service_total', static function (TextColumn $column) {
                    $column->rupiah()->label('Service')->sortable(false);

                    $column->summarize([
                        Summarizer::make()
                            ->formatStateUsing(function ($state) {
                                return str($state)->rupiah();
                            })
                            ->using(function (Builder $query) {
                                return $query->sum(DB::raw("CASE WHEN type = 'SERVICE' THEN amount ELSE 0 END"));
                            }),
                    ]);
                }),

                fi_ta_column('turning_total', static function (TextColumn $column) {
                    $column->rupiah()->label('Bubut')->sortable(false);

                    $column->summarize([
                        Summarizer::make()
                            ->formatStateUsing(function ($state) {
                                return str($state)->rupiah();
                            })
                            ->using(function (Builder $query) {
                                return $query->sum(DB::raw("CASE WHEN type = 'TURNING' THEN amount ELSE 0 END"));
                            }),
                    ]);
                }),

                fi_ta_column('benzene_total', static function (TextColumn $column) {
                    $column->rupiah()->label('Bensol')->sortable(false);

                    $column->summarize([
                        Summarizer::make()
                            ->formatStateUsing(function ($state) {
                                return str($state)->rupiah();
                            })
                            ->using(function (Builder $query) {
                                return $query->sum(DB::raw("CASE WHEN type = 'BENZEN' THEN amount ELSE 0 END"));
                            }),
                    ]);
                }),
            ]);

        $table->paginated(false);

        return $table;
    }

    /**
     * @return EloquentBuilder
     */
    private function query() : EloquentBuilder
    {
        return
            OrderItem::query()->whereHas('order', function ($query) {
                $query->day($this->getRecord()->period);
            });
    }
}
