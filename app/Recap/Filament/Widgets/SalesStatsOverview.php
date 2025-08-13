<?php

namespace App\Recap\Filament\Widgets;

use App\Order\Enums\Type;
use App\Order\Models\Order;
use App\Order\Models\OrderItem;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Illuminate\Contracts\Database\Query\Expression;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Livewire\Attributes\On;

class SalesStatsOverview extends BaseWidget
{
    /**
     * @var array
     */
    protected array $date = [];

    /**
     * @var string
     */
    protected static string $view = 'vendor.filament.overview';

    /**
     * @var string|null
     */
    protected static ?string $pollingInterval = null;

    /**
     * @return int
     */
    protected function getColumns() : int
    {
        return 5;
    }

    /**
     * @param  string $str
     * @param  string $end
     * @return void
     */
    #[On('update')]
    public function date(string $str, string $end) : void
    {
        $this->date = [
            Carbon::createFromDate($str),
            Carbon::createFromDate($end),
        ];
    }

    /**
     * @return void
     */
    public function mount() : void
    {
        if (empty($this->date)) {
            $this->date = [
                today(), today(),
            ];
        }
    }

    /**
     * @return array|Stat[]
     */
    protected function getStats() : array
    {
        $stats = [
            fi_wi_stat(function (Stat $stat) {
                $stat
                    ->label('TOTAL SALES')
                    ->icon('lucide-dollar-sign')
                    ->description($this->description())
                    ->value(function () {
                        return number(Order::whereBetween('date', $this->date)->sum(DB::raw('amount - discount')))->currency();
                    });
            }),
        ];

        foreach (Type::cases() as $type) {
            $stats[] = fi_wi_stat(function (Stat $stat) use ($type) {
                $stat
                    ->label($type->getLabel())
                    ->icon($type->getIcon())
                    ->description($this->description())
                    ->value(function () use ($type) {
                        return number($this->query($type->query()))->currency();
                    });
            });
        }

        return $stats;
    }

    /**
     * @return string
     */
    protected function description() : string
    {
        [$str, $end] = $this->date;

        if ($str->format('Y-m-d') === $end->format('Y-m-d')) {
            return 'Overview for ' . $str->format('d M Y');
        }

        return 'Overview from ' . $str->format('d M Y') . ' to ' . $end->format('d M Y');
    }

    /**
     * @param  Expression $expression
     * @return string|float|int
     */
    protected function query(Expression $expression) : string|float|int
    {
        return
            OrderItem::whereHas('order', function ($query) {
                $query->whereBetween('date', $this->date);
            })
                ->sum($expression);
    }
}
