<?php

namespace App\Unit\Filament\Resources\UnitResource\Pages;

use App\Support\Filament\Tables\Actions\DeleteAction;
use App\Unit\Filament\Resources\UnitResource;
use App\Unit\Filament\Resources\UnitResource\Actions\ModifyAction;
use App\Unit\Models\Unit;
use Filament\Actions\Action;
use Filament\Actions\ActionGroup;
use Filament\Resources\Pages\ListRecords;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Contracts\Database\Eloquent\Builder;
use Illuminate\Support\HtmlString;

class ListUnits extends ListRecords
{
    protected static string $resource = UnitResource::class;

    /**
     * @return array|Action[]|ActionGroup[]
     */
    protected function getHeaderActions() : array
    {
        return [
            fi_action(function (UnitResource\Actions\CreateAction $action) {
                //
            }),
        ];
    }

    public function table(Table $table) : Table
    {
        $table
            ->columns([
                fi_ta_column('name', static function (TextColumn $column) {
                    $column->label('Nama');
                }),

                 fi_ta_column('symbol', static function (TextColumn $column) {
                    $column->label('Alias');
                }),

                fi_ta_column('products_count', function (TextColumn $column) {
                    $column->label('Related Products')->formatStateUsing(fn($state) => new HtmlString(
                        $state . ' <span class="text-xs">products</span>',
                    ));
                }),

                fi_ta_column('creator.name', static function (TextColumn $column) {
                    $column->default('System');
                }),

                fi_ta_column('created_at', function (TextColumn $column) {
                    $column->label('Created At')->dateTime();
                }),

                fi_ta_column('updated_at', function (TextColumn $column) {
                    $column->label('Updated At')->dateTime();
                }),
            ]);

        $table->actions([
            fi_action(function (ModifyAction $action) {
               //
            }),

            fi_action(function (DeleteAction $action) {
                $action->disabled(function (Unit $record) {
                    return $record->products()->exists();
                });
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
                $query->withCount('products');
            });
    }
}
