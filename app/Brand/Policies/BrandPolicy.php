<?php

namespace App\Brand\Policies;

use App\Brand\Models\Brand;
use App\User\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class BrandPolicy
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
     * @param  User  $user
     * @param  Brand $brand
     * @return bool
     */
    public function view(User $user, Brand $brand) : bool
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
     * @param  User  $user
     * @param  Brand $brand
     * @return bool
     */
    public function update(User $user, Brand $brand) : bool
    {
        return $user->permission->admin() || $user->permission->inventory();
    }

    /**
     * @param  User  $user
     * @param  Brand $brand
     * @return bool
     */
    public function delete(User $user, Brand $brand) : bool
    {
        return $user->permission->admin() || $user->permission->inventory();
    }

    /**
     * @param  User  $user
     * @param  Brand $brand
     * @return bool
     */
    public function restore(User $user, Brand $brand) : bool
    {
        return $user->permission->admin() || $user->permission->inventory();
    }

    /**
     * @param  User  $user
     * @param  Brand $brand
     * @return bool
     */
    public function forceDelete(User $user, Brand $brand) : bool
    {
        return $user->permission->admin() || $user->permission->inventory();
    }
}
