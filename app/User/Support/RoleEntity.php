<?php

namespace App\User\Support;

use App\User\Enums\Role;
use App\User\Models\User;

class RoleEntity
{
    /**
     * @param  User $user
     */
    public function __construct(protected User $user)
    {
        //
    }

    /**
     * @return bool
     */
    public function admin() : bool
    {
        return $this->user->hasRole(Role::ADMIN);
    }

    /**
     * @return bool
     */
    public function cashier() : bool
    {
        return $this->user->hasRole(Role::CASHIER);
    }

    /**
     * @return bool
     */
    public function mechanic() : bool
    {
        return $this->user->hasRole(Role::MECHANIC);
    }

    /**
     * @return bool
     */
    public function inventory() : bool
    {
        return $this->user->hasRole(Role::INVENTORY);
    }
}
