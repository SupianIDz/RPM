<?php

namespace App\Recap\Filament\Resources\RecapDailyResource\Pages;

use App\Recap\Filament\Resources\RecapDailyResource;
use Filament\Resources\Pages\ListRecords;
use Filament\Tables\Actions\SelectAction;
use Filament\Tables\Columns\Summarizers\Sum;
use Filament\Tables\Columns\Summarizers\Summarizer;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Contracts\Database\Query\Builder as QBuilder;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Livewire\Attributes\Url;

class ListRecapDailies extends ListRecords
{
    protected static string $resource = RecapDailyResource::class;

    #[Url(as: 'month')]
    public ?string $month = null;

    #[Url(as: 'year')]
    public ?string $year = null;

    /**
     * @return void
     */
    public function mount() : void
    {
        $this->month = date('m');
        $this->year = date('Y');
    }

    /**
     * @param  Table $table
     * @return Table
     */
    public function table(Table $table) : Table
    {
        $table
            ->headerActions([
                fi_action(static function (SelectAction $action) {
                    $action
                        ->options(collect(range(1, 12))->mapWithKeys(fn($month) => [
                            $month => strtoupper(Carbon::create()?->month($month)->format('M')),
                        ]));
                }, 'month'),

                fi_action(static function (SelectAction $action) {
                    $action
                        ->options(collect(range(2025, date('Y')))->mapWithKeys(fn($year) => [
                            $year => 'TAHUN ' . $year,
                        ]));
                }, 'year'),
            ])
            ->columns([
                fi_ta_column('period', static function (TextColumn $table) {
                    $table->date('d M Y');
                }),

                fi_ta_column('total_order', static function (TextColumn $table) {
                    $table->label('Transaction');

                    $table
                        ->summarize([
                            Summarizer::make('total_value')
                                ->using(function (QBuilder $query) {
                                    return $query->sum(DB::raw('total_order_c + total_order_t + total_order_m'));
                                })
                                ->formatStateUsing(function ($state) {
                                    return number($state)->format();
                                }),
                        ]);
                }),

                fi_ta_column('total_value_c', function (TextColumn $table) {
                    $table->label('Cash')->rupiah();

                    $table
                        ->summarize([
                            Sum::make('total_value_c')
                                ->label('')
                                ->formatStateUsing(function ($state) {
                                    return str($state)->rupiah();
                                }),
                        ]);
                }),

                fi_ta_column('total_value_t', function (TextColumn $table) {
                    $table->label('Transfer')->rupiah();

                    $table
                        ->summarize([
                            Sum::make('total_value_t')
                                ->label('')
                                ->formatStateUsing(function ($state) {
                                    return str($state)->rupiah();
                                }),
                        ]);
                }),

                fi_ta_column('total_value_m', function (TextColumn $table) {
                    $table->label('Marketplace')->rupiah();

                    $table
                        ->summarize([
                            Sum::make('total_value_m')
                                ->label('')
                                ->formatStateUsing(function ($state) {
                                    return str($state)->rupiah();
                                }),
                        ]);
                }),

                fi_ta_column('total_value', function (TextColumn $table) {
                    $table->label('Total Revenue')->rupiah();

                    $table
                        ->summarize([
                            Summarizer::make('total_value')
                                ->using(function (QBuilder $query) {
                                    return $query->sum(DB::raw('total_value_c + total_value_t + total_value_m'));
                                })
                                ->formatStateUsing(function ($state) {
                                    return str($state)->rupiah();
                                }),
                        ]);
                }),
            ]);

        $table
            ->defaultSort('period')
            ->searchable(false)
            ->paginated(false);

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
                $query->when($this->month, function (Builder $query) {
                    $query->whereMonth('period', $this->month);
                });

                $query->when($this->year, function (Builder $query) {
                    $query->whereYear('period', $this->year);
                });
            });
    }
}
