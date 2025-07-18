<?php

namespace App\User\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;

class Role extends \Spatie\Permission\Models\Role
{
    use HasUuids;

    /**
     * @return class-string[]
     */
    protected function casts() : array
    {
        return [
            'name' => \App\User\Enums\Role::class,
        ];
    }
}
