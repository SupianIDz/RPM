<?php

namespace App\User\Policies;

use App\User\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class UserPolicy
{
    use HandlesAuthorization;

    /**
     * @param  User $user
     * @return bool
     */
    public function viewAny(User $user) : bool
    {
        return $user->permission->admin();
    }

    /**
     * @param  User $user
     * @param  User $model
     * @return bool
     */
    public function view(User $user, User $model) : bool
    {
        return $user->permission->admin();
    }

    /**
     * @param  User $user
     * @return bool
     */
    public function create(User $user) : bool
    {
        return $user->permission->admin();
    }

    /**
     * @param  User $user
     * @param  User $model
     * @return bool
     */
    public function update(User $user, User $model) : bool
    {
        return $user->permission->admin();
    }

    /**
     * @param  User $user
     * @param  User $model
     * @return bool
     */
    public function delete(User $user, User $model) : bool
    {
        return $user->permission->admin();
    }

    /**
     * @param  User $user
     * @param  User $model
     * @return bool
     */
    public function restore(User $user, User $model) : bool
    {
        return $user->permission->admin();
    }

    /**
     * @param  User $user
     * @param  User $model
     * @return bool
     */
    public function forceDelete(User $user, User $model) : bool
    {
        return $user->permission->admin();
    }
}
