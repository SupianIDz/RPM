<?php

namespace App\User\Services;

use App\User\Models\User;
use Closure;
use Exception;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Support\Facades\Auth;
use RuntimeException;

class ImpersonationService
{
    /**
     * @param  User|null $impersonator
     */
    public function __construct(protected User|null $impersonator = null)
    {
        //
    }

    /**
     * @return bool
     */
    public function check() : bool
    {
        return session()?->has('impersonate.impersonated');
    }

    /**
     * @param  User    $user
     * @param  Closure $route
     * @return self
     * @throws Exception
     */
    public function begin(User $user, Closure $route) : self
    {
        if (! $this->impersonator->permission->admin()) {
            throw new RuntimeException('You are not allowed to impersonate.');
        }

        if ($this->impersonator->is($user)) {
            throw new RuntimeException('Cannot impersonate yourself.');
        }

        Auth::login($user);

        return $this->setAuthPassword($user)->setImpersonationState($user, $route);
    }

    /**
     * @return string
     */
    public function leave() : string
    {
        /**
         * @var Authenticatable $user
         */
        $user = User::find(
            session('impersonate.impersonator'),
        );

        Auth::login($user);

        return $this->setAuthPassword($user)->getRouteBackAndFlushState();
    }

    /**
     * @param  Authenticatable $user
     * @return self
     */
    private function setAuthPassword(Authenticatable $user) : self
    {
        session([
            'password_hash_web' => $user->getAuthPassword(),
        ]);

        return $this;
    }

    /**
     * @param  User    $user
     * @param  Closure $route
     * @return self
     */
    public function setImpersonationState(User $user, Closure $route) : self
    {
        session([
            'impersonate' => [
                'impersonated' => $user->getKey(),
                'impersonator' => $this->impersonator->getKey(),
                'previous_url' => $route(),
            ],
        ]);

        return $this;
    }

    /**
     * @return string
     */
    private function getRouteBackAndFlushState() : string
    {
        $back = session('impersonate.previous_url');

        session()?->forget('impersonate');

        return $back;
    }
}
