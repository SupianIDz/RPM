<?php

namespace App\User\Models;

use Database\Factories\UserFactory;
use Filament\Models\Contracts\FilamentUser;
use Filament\Models\Contracts\HasAvatar;
use Filament\Panel;
use Illuminate\Database\Eloquent\Attributes\UseFactory;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Spatie\Permission\Traits\HasRoles;

#[UseFactory(UserFactory::class)]
class User extends \Illuminate\Foundation\Auth\User implements FilamentUser, HasAvatar
{
    use HasUuids, HasFactory, HasRoles;

    /**
     * @var string[]
     */
    protected $fillable = [
        'name', 'email', 'email_verified_at', 'password', 'remember_token',
    ];

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

    /**
     * @param  Panel $panel
     * @return bool
     */
    public function canAccessPanel(Panel $panel) : bool
    {
        return true;
    }

    /**
     * @return string|null
     */
    public function getFilamentAvatarUrl() : ?string
    {
        return $this->avatar;
    }
}
