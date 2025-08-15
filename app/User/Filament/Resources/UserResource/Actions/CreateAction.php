<?php

namespace App\User\Filament\Resources\UserResource\Actions;

use App\User\Models\User;
use Illuminate\Support\Facades\DB;

class CreateAction extends \App\Support\Filament\Actions\CreateAction
{
    protected function setUp() : void
    {
        parent::setUp();

        $this->form(new Forms\Form()->configure());

        $this
            ->mutateFormDataUsing(function (array $data) {
                return array_merge($data, [
                    'email_verified_at' => now(),
                ]);
            })
            ->action(function (array $data) {
                $res = DB::transaction(function () use ($data) {
                    /**
                     * @var User $user
                     */
                    $user = User::updateOrCreate(['email' => $data['email']], $data);
                    $user->syncRoles($data['role']);
                });

                $res ? $this->success() : $this->failure();
            });
    }
}
