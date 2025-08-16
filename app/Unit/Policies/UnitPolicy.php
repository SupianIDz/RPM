<?php

namespace App\Unit\Policies;

use App\Unit\Models\Unit;
use App\User\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class UnitPolicy
{
    use HandlesAuthorization;

    /**
     * @param  User $user
     * @return bool
     */
    public function viewAny(User $user) : bool
    {
        return $user->permission->admin() || $user->permission->inventory();
    }

    /**
     * @param  User $user
     * @param  Unit $unit
     * @return bool
     */
    public function view(User $user, Unit $unit) : bool
    {
        return $user->permission->admin() || $user->permission->inventory();
    }

    /**
     * @param  User $user
     * @return bool
     */
    public function create(User $user) : bool
    {
        return $user->permission->admin() || $user->permission->inventory();
    }

    /**
     * @param  User $user
     * @param  Unit $unit
     * @return bool
     */
    public function update(User $user, Unit $unit) : bool
    {
        return $user->permission->admin() || $user->permission->inventory();
    }

    /**
     * @param  User $user
     * @param  Unit $unit
     * @return bool
     */
    public function delete(User $user, Unit $unit) : bool
    {
        return $user->permission->admin() || $user->permission->inventory();
    }

    /**
     * @param  User $user
     * @param  Unit $unit
     * @return bool
     */
    public function restore(User $user, Unit $unit) : bool
    {
        return $user->permission->admin() || $user->permission->inventory();
    }

    /**
     * @param  User $user
     * @param  Unit $unit
     * @return bool
     */
    public function forceDelete(User $user, Unit $unit) : bool
    {
        return $user->permission->admin() || $user->permission->inventory();
    }
}
