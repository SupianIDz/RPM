<?php

namespace App\Order\Livewire;

use App\Order\Models\Order;
use App\Order\Models\OrderItem;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\Summarizers\Summarizer;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Concerns\InteractsWithTable;
use Filament\Tables\Contracts\HasTable;
use Filament\Tables\Table;
use Illuminate\Contracts\Database\Query\Builder;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\HtmlString;
use Livewire\Component;
use Override;

class Items extends Component implements HasTable, HasForms
{
    use InteractsWithTable, InteractsWithForms;

    public Order $order;

    /**
     * @return View
     */
    public function render() : View
    {
        return view('orders.detail.product');
    }

    /**
     * @param  Table $table
     * @return Table
     */
    public function table(Table $table) : Table
    {
        $table
            ->relationship(fn() => $this->order->items())
            ->columns([
                fi_ta_column('product.name', static function (ImageColumn $column) {
                    $column->disk('product:image')->toggleable(false);
                }),

                fi_ta_column('name', static function (TextColumn $column) {
                    $column
                        ->description(function (OrderItem $record) {
                            return new HtmlString('<span class="text-xs text-warning-600">' . $record->product->code . '</span>');
                        });

                    $column->toggleable(false);
                }),

                fi_ta_column('amount', static function (TextColumn $column) {
                    $column->rupiah();
                    $column->toggleable(false);
                }),

                fi_ta_column('quantity', static function (TextColumn $column) {
                    $column
                        ->toggleable(false)
                        ->verticallyAlignCenter()
                        ->formatStateUsing(function ($state, OrderItem $record) {
                            return new HtmlString($state . ' <span class="text-xs">' . $record->product->unit->name . '</span>');
                        });
                }),

                fi_ta_column('total', static function (TextColumn $column) {
                    $column
                        ->label('Sub Total')
                        ->toggleable(false)
                        ->rupiah();

                    $column->summarize([
                        Summarizer::make()
                            ->label('TOTAL')
                            ->using(function (Builder $query) {
                                return $query->sum(DB::raw('amount * quantity'));
                            })
                            ->formatStateUsing(function ($state) {
                                return str($state)->rupiah();
                            }),
                    ]);
                }),
            ]);

        $table
            ->searchable(false)->paginated(false);

        return $table;
    }

    /**
     * @return string
     */
    #[Override]
    public function getName() : string
    {
        return __CLASS__;
    }
}
