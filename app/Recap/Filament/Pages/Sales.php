<?php

namespace App\Recap\Filament\Pages;

use App\Order\Models\OrderItem;
use App\Recap\Filament\Actions\ExportAction;
use App\Recap\Filament\Clusters\Recap;
use App\Recap\Filament\Widgets\SalesStatsOverview;
use Filament\Actions\Action;
use Filament\Actions\ActionGroup;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Pages\Page;
use Filament\Pages\SubNavigationPosition;
use Filament\Tables\Columns\Summarizers\Sum;
use Filament\Tables\Columns\Summarizers\Summarizer;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Concerns\InteractsWithTable;
use Filament\Tables\Contracts\HasTable;
use Filament\Tables\Enums\FiltersLayout;
use Filament\Tables\Table;
use Illuminate\Contracts\Database\Query\Builder;
use Illuminate\Database\Eloquent\Builder as EloquentBuilder;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Livewire\Attributes\Url;
use Malzariey\FilamentDaterangepickerFilter\Enums\DropDirection;
use Malzariey\FilamentDaterangepickerFilter\Enums\OpenDirection;
use Malzariey\FilamentDaterangepickerFilter\Filters\DateRangeFilter;

class Sales extends Page implements HasTable
{
    use InteractsWithTable, InteractsWithForms;

    #[Url]
    public string|null $date = null;

    protected static ?string $cluster = Recap::class;

    protected static string $view = 'sold';

    protected static ?string $slug = 'sales';

    protected static ?string $navigationIcon = 'lucide-candlestick-chart';

    protected static ?string $navigationLabel = 'SALES';

    protected static ?int $navigationSort = 0;

    /**
     * @var SubNavigationPosition
     */
    protected static SubNavigationPosition $subNavigationPosition = SubNavigationPosition::Top;

    /**
     * @return void
     */
    public function mount() : void
    {
        if (! $this->date) {
            $this->date = date('d-m-y');
        }
    }

    /**
     * @return void
     */
    public function updatedTableFilters() : void
    {
        $this->date = $this->tableFilters['date']['date'];

        [$str, $end] = explode('-', $this->date);

        $this
            ->dispatch('update',
                Carbon::createFromFormat('d/m/Y', trim($str))?->format('Y-m-d'),
                Carbon::createFromFormat('d/m/Y', trim($end))?->format('Y-m-d'),
            )
            ->to(SalesStatsOverview::class);
    }

    /**
     * @return class-string[]
     */
    protected function getHeaderWidgets() : array
    {
        return [
            SalesStatsOverview::class,
        ];
    }

    /**
     * @return array|Action[]|ActionGroup[]
     */
    protected function getHeaderActions() : array
    {
        return [
            fi_action(static function (ExportAction $action) {
                $action->route('exports.sales');
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
            ->query($this->query())
            ->searchable(false)
            ->columns([
                fi_ta_column('invoice', function (TextColumn $column) {
                    //
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
                                return $query->sum(DB::raw("CASE WHEN type = 'BENZENE' THEN amount ELSE 0 END"));
                            }),
                    ]);
                }),
            ]);

        $table
            ->paginated(false)
            ->searchable(false);

        $table
            ->filters([
                fi_ta_filter(static function (DateRangeFilter $filter) {
                    $filter
                        ->defaultToday()
                        ->hiddenLabel()
                        ->drops(DropDirection::AUTO)
                        ->opens(OpenDirection::RIGHT)
                        ->modifyQueryUsing(function (EloquentBuilder $query, ?Carbon $startDate, ?Carbon $endDate, $dateString) {
                            $query->when(filled($dateString), function (EloquentBuilder $query) use ($startDate, $endDate) {
                                $query->whereHas('order', function (EloquentBuilder $query) use ($endDate, $startDate) {
                                    $query->whereBetween('date', [$startDate, $endDate]);
                                });
                            });
                        });
                }, 'date'),
            ], FiltersLayout::AboveContent);

        return $table;
    }

    /**
     * @return EloquentBuilder
     */
    private function query() : EloquentBuilder
    {
        return
            OrderItem::query();
    }
}
