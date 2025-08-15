<?php

namespace App\Recap\Filament\Actions;

use Filament\Actions\Action;
use Malzariey\FilamentDaterangepickerFilter\Fields\DateRangePicker;

class ExportAction extends Action
{
    /**
     * @return void
     */
    protected function setUp() : void
    {
        parent::setUp();

        $this
            ->label('Export')
            ->openUrlInNewTab()
            ->requiresConfirmation()
            ->action(function (array $data) {
                return redirect(route('exports.sales') . '?date=' . str($data['date']));
            });

        $this->form([
            fi_form_field('date', static function (DateRangePicker $field) {
                $field->label('Date')->defaultToday()->required();

                $field->helperText('Select date range to export');
            }),
        ]);
    }
}
