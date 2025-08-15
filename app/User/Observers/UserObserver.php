<?php

namespace App\User\Observers;

use App\User\Models\User;

class UserObserver
{
    /**
     * @param  User $user
     * @return void
     */
    public function deleted(User $user) : void
    {
        $user->update([
            'email' => $user->email . '.deleted',
        ]);
    }
}
