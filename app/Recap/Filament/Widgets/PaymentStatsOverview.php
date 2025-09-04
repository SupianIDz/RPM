<?php

namespace App\Recap\Filament\Widgets;

use App\Order\Enums\Payment;
use App\Order\Models\Order;
use Arr;
use Filament\Widgets\StatsOverviewWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Livewire\Attributes\On;

class PaymentStatsOverview extends StatsOverviewWidget
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
     * @return Stat[]
     */
    protected function getStats() : array
    {
        $stats = [
            fi_wi_stat(function (Stat $stat) {
                $stat
                    ->label('TOTAL PENJUALAN')
                    ->icon('lucide-dollar-sign')
                    ->description($this->description())
                    ->value(function () {
                        return number(Order::whereBetween('date', $this->date)->sum(DB::raw('amount - discount')))->currency();
                    });
            }),

            fi_wi_stat(function (Stat $stat) {
                $stat
                    ->label('TOTAL KEUNTUNGAN')
                    ->icon('lucide-dollar-sign')
                    ->description($this->description())
                    ->value(function () {
                        $profit = DB::table('order_items')
                            ->join('orders', 'orders.invoice', '=', 'order_items.invoice')
                            ->whereBetween('orders.date', $this->date)
                            ->sum(DB::raw(
                                'COALESCE(order_items.quantity,0) * (COALESCE(order_items.amount,0) - COALESCE(order_items.cogs,0))',
                            ));

                        return number($profit)->currency();
                    });
            }),
        ];

        foreach (Payment::cases() as $payment) {
            if ($payment === Payment::MARKETPLACE) {
                continue;
            }

            $stats[] = fi_wi_stat(function (Stat $stat) use ($payment) {
                $label = $payment->getLabel();

                if ($payment === Payment::TRANSFER) {
                    $label = $label . ' / MARKETPLACE';
                }

                $stat
                    ->label('VIA ' . $label)
                    ->icon($payment->getIcon())
                    ->description($this->description())
                    ->value(function () use ($payment) {
                        return number($this->query($payment))->currency();
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
            return 'Ringkasan untuk ' . $str->format('d M Y');
        }

        return 'Ringkasan untuk ' . $str->format('d M Y') . ' s/d ' . $end->format('d M Y');
    }

    /**
     * @param  Payment $payment
     * @return string|float|int
     */
    protected function query(Payment $payment) : string|float|int
    {
        if ($payment === Payment::MARKETPLACE || $payment === Payment::TRANSFER) {
            $payment = [Payment::TRANSFER, Payment::MARKETPLACE];
        }

        return Order::whereBetween('date', $this->date)->whereIn('payment', Arr::wrap($payment))->sum('amount');
    }
}
