<?php

namespace App\User\Filament\Resources\UserResource\Actions;

use App\User\Models\User;
use App\User\Services\ImpersonationService;
use Filament\Facades\Filament;
use Filament\Notifications\Notification;
use Filament\Support\Enums\IconSize;
use Filament\Tables\Actions\Action;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\HtmlString;
use Throwable;

class SignInAction extends Action
{
    protected bool $status = false;

    /**
     * @return void
     */
    protected function setUp() : void
    {
        parent::setUp();

        $this
            ->hiddenLabel()
            ->tooltip('IMPERSONATE')
            ->icon('lucide-fingerprint')
            ->iconSize(IconSize::Medium)
            ->color(function () {
                return $this->isDisabled() ? 'gray' : 'rose';
            })
            ->hidden(function (Model $record) {
                return config('app.env') === 'production';
            })
            ->requiresConfirmation()
            ->modalHeading('IMPERSONATE')
            ->modalDescription(function (Model $record) {
                $record = $this->evaluateUser($record);

                return
                    new HtmlString(
                        'Anda akan masuk dan bertindak sebagai <br/><span class="text-gray-500 font-bold">' . $record->name . '</span>',
                    );
            })
            ->modalIcon('lucide-fingerprint')
            ->action(function (Model $record) {
                try {
                    new ImpersonationService(auth()->user())->begin($this->evaluateUser($record), function () {
                        return request('fingerprint.path', request()->header('referer')) ?? Filament::getCurrentPanel()->getUrl();
                    });

                    $this->status = true;
                } catch (Throwable $exception) {
                    $this
                        ->failureNotification(function () use ($exception) {
                            return Notification::make()->danger()->title('Error')->body(
                                'An error occurred: ' . $exception->getMessage(),
                            );
                        })
                        ->failure();
                }
            })
            ->after(function () {
                if ($this->status) {
                    $this->redirect(url('panel'));
                }
            });
    }

    /**
     * @param  Model $record
     * @return User|Model|null
     */
    private function evaluateUser(Model $record) : User|Model|null
    {
        return $record;
    }
}
