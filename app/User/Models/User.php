<?php

namespace App\User\Models;

use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Attributes\UseFactory;
use Illuminate\Database\Eloquent\Casts\Attribute;
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

    /**
     * @return Attribute
     */
    protected function avatar() : Attribute
    {
        return
            Attribute::get(function () {
                return 'https://api.dicebear.com/9.x/bottts-neutral/svg?seed=' . md5($this->email);
            });
    }
}
