<?php

namespace App\Product\Policies;

use App\Product\Models\Product;
use App\User\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class ProductPolicy
{
    use HandlesAuthorization;

    /**
     * @param  User $user
     * @return bool
     */
    public function viewAny(User $user) : bool
    {
        return true;
    }

    /**
     * @param  User    $user
     * @param  Product $product
     * @return bool
     */
    public function view(User $user, Product $product) : bool
    {
        return true;
    }

    /**
     * @param  User $user
     * @return bool
     */
    public function create(User $user) : bool
    {
        return $user->permission->admin() || $user->permission->inventory() || $user->permission->cashier();
    }

    /**
     * @param  User    $user
     * @param  Product $product
     * @return bool
     */
    public function update(User $user, Product $product) : bool
    {
        return $user->permission->admin() || $user->permission->inventory() || $user->permission->cashier();
    }

    /**
     * @param  User    $user
     * @param  Product $product
     * @return bool
     */
    public function delete(User $user, Product $product) : bool
    {
        return $user->permission->admin() || $user->permission->inventory() || $user->permission->cashier();
    }

    /**
     * @param  User    $user
     * @param  Product $product
     * @return bool
     */
    public function restore(User $user, Product $product) : bool
    {
        return $user->permission->admin() || $user->permission->inventory() || $user->permission->cashier();
    }

    /**
     * @param  User    $user
     * @param  Product $product
     * @return bool
     */
    public function forceDelete(User $user, Product $product) : bool
    {
        return $user->permission->admin() || $user->permission->inventory();
    }
}
