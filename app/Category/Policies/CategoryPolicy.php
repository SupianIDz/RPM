<?php

namespace App\Category\Policies;

use App\Category\Models\Category;
use App\User\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class CategoryPolicy
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
     * @param  Category $category
     * @return bool
     */
    public function view(User $user, Category $category) : bool
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
     * @param  Category $category
     * @return bool
     */
    public function update(User $user, Category $category) : bool
    {
        return $user->permission->admin() || $user->permission->inventory();
    }

    /**
     * @param  User  $user
     * @param  Category $category
     * @return bool
     */
    public function delete(User $user, Category $category) : bool
    {
        return $user->permission->admin() || $user->permission->inventory();
    }

    /**
     * @param  User  $user
     * @param  Category $category
     * @return bool
     */
    public function restore(User $user, Category $category) : bool
    {
        return $user->permission->admin() || $user->permission->inventory();
    }

    /**
     * @param  User  $user
     * @param  Category $category
     * @return bool
     */
    public function forceDelete(User $user, Category $category) : bool
    {
        return $user->permission->admin() || $user->permission->inventory();
    }
}
