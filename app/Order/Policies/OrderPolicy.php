<?php

namespace App\Order\Policies;

use App\Order\Models\Order;
use App\User\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class OrderPolicy
{
    use HandlesAuthorization;

    /**
     * @param  User $user
     * @return bool
     */
    public function viewAny(User $user) : bool
    {
        return $user->permission->admin() || $user->permission->cashier();
    }

    /**
     * @param  User  $user
     * @param  Order $order
     * @return bool
     */
    public function view(User $user, Order $order) : bool
    {
        return $user->permission->admin() || $user->permission->cashier();
    }

    /**
     * @param  User $user
     * @return bool
     */
    public function create(User $user) : bool
    {
        return $user->permission->admin() || $user->permission->cashier();
    }

    /**
     * @param  User  $user
     * @param  Order $order
     * @return bool
     */
    public function update(User $user, Order $order) : bool
    {
        return $user->permission->admin() || $user->permission->cashier();
    }

    /**
     * @param  User  $user
     * @param  Order $order
     * @return bool
     */
    public function delete(User $user, Order $order) : bool
    {
        return $user->permission->admin() || $user->permission->cashier();
    }

    /**
     * @param  User  $user
     * @param  Order $order
     * @return bool
     */
    public function restore(User $user, Order $order) : bool
    {
        return $user->permission->admin() || $user->permission->cashier();
    }

    /**
     * @param  User  $user
     * @param  Order $order
     * @return bool
     */
    public function forceDelete(User $user, Order $order) : bool
    {
        return $user->permission->admin() || $user->permission->cashier();
    }
}
