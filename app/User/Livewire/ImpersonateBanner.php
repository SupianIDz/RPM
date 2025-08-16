<?php

namespace App\User\Livewire;

use App\User\Services\ImpersonationService;
use Exception;
use Illuminate\Contracts\View\View;
use Livewire\Component;

class ImpersonateBanner extends Component
{
    /**
     * @return View
     * @throws Exception
     */
    public function render() : View
    {
        return view('livewire.impersonate', [
            'user' => auth()->user(),
        ]);
    }

    /**
     * @return void
     */
    public function leave() : void
    {
        $this->redirect(new ImpersonationService()->leave());
    }

    /**
     * @return string
     */
    public function getName() : string
    {
        return __CLASS__;
    }
}
