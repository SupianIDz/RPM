<?php

namespace App\Recap\Filament\Resources\RecapDailyResource\Pages;

use App\Order\Models\OrderItem;
use App\Recap\Filament\Resources\RecapDailyResource;
use Filament\Resources\Pages\ViewRecord;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Concerns\InteractsWithTable;
use Filament\Tables\Contracts\HasTable;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder as EloquentBuilder;

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
                fi_ta_column('invoice', function (TextColumn $column){

                }),

                fi_ta_column('name', function (TextColumn $column) {
                    //
                }),

                fi_ta_column('quantity', function (TextColumn $column) {
                    $column->label('QTY');
                }),

                fi_ta_column('amount', function (TextColumn $column) {
                    $column->rupiah();
                })
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
