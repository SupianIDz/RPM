<?php

namespace App\User\Models;

use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Attributes\UseFactory;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Spatie\Permission\Traits\HasRoles;

#[UseFactory(UserFactory::class)]
class User extends \Illuminate\Foundation\Auth\User
{
    use HasUuids, HasFactory, HasRoles;

    /**
     * @var string[]
     */
    protected $hidden = [
        'password', 'remember_token',
    ];
}
