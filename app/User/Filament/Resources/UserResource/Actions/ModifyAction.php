<?php

namespace App\User\Filament\Resources\UserResource\Actions;

use App\User\Models\User;
use Illuminate\Support\Facades\DB;
use function Symfony\Component\Translation\t;

class ModifyAction extends \App\Support\Filament\Tables\Actions\ModifyAction
{
    /**
     * @return void
     */
    protected function setUp() : void
    {
        parent::setUp();

        $this->form(new Forms\Form()->configure(edit: true));

        $this
            ->mutateRecordDataUsing(function (array $data, User $record) {
                return array_merge($data, [
                    'role' => $record->roles->first()?->name,
                ]);
            })
            ->action(function (array $data) {
                $res = DB::transaction(function () use ($data) {
                    /**
                     * @var User $user
                     */
                    $user = User::updateOrCreate(['email' => $data['email']], $data);

                    return $user && $user->syncRoles($data['role']);
                });

                $res ? $this->success() : $this->failure();
            });
    }
}
