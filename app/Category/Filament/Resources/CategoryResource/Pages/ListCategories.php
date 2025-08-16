<?php

namespace App\Category\Filament\Resources\CategoryResource\Pages;

use App\Category\Filament\Resources\CategoryResource;
use App\Category\Filament\Resources\CategoryResource\Actions\CreateAction;
use App\Category\Filament\Resources\CategoryResource\Actions\ModifyAction;
use App\Support\Filament\Tables\Actions\DeleteAction;
use Filament\Actions\Action;
use Filament\Actions\ActionGroup;
use Filament\Resources\Pages\ListRecords;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Contracts\Database\Eloquent\Builder;
use Illuminate\Support\HtmlString;

class ListCategories extends ListRecords
{
    protected static string $resource = CategoryResource::class;

    /**
     * @return array|Action[]|ActionGroup[]
     */
    protected function getHeaderActions() : array
    {
        return [
            fi_action(function (CreateAction $action) {
                //
            }),
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
                fi_ta_column('name', function (TextColumn $column) {
                    $column->label('Nama');
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

        $table
            ->actions([
                fi_action(function (ModifyAction $action) {
                    //
                }),

                fi_action(static function (DeleteAction $action) {
                    $action->modalDescription(new HtmlString(
                        'Are you sure you want to delete this categiry? <br/> All associated products will be unlinked from it.',
                    ));
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
                $query
                    ->with('child')
                    ->withCount('products');
            });
    }
}
