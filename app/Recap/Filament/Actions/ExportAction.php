<?php

namespace App\Recap\Filament\Actions;

use Filament\Actions\Action;
use Malzariey\FilamentDaterangepickerFilter\Fields\DateRangePicker;

class ExportAction extends Action
{
    protected string $route;

    /**
     * @return void
     */
    protected function setUp() : void
    {
        parent::setUp();

        $this
            ->label('Export')
            ->icon('lucide-download')
            ->modalIcon('lucide-download')
            ->color('warning')
            ->openUrlInNewTab()
            ->requiresConfirmation()
            ->action(function (array $data) {
                return redirect(route($this->route) . '?date=' . str($data['date']));
            });

        $this->form([
            fi_form_field('date', static function (DateRangePicker $field) {
                $field->label('Date')->defaultToday()->required();

                $field->helperText('Select date range to export');
            }),
        ]);
    }

    /**
     * @param  string $route
     * @return $this
     */
    public function route(string $route) : static
    {
        $this->route = $route;

        return $this;
    }
}
