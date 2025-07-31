<?php

namespace App\Customer\Data;

use Spatie\LaravelData\Data;

class CustomerData extends Data
{
    /**
     * @param  string      $name
     * @param  string|null $phone
     */
    public function __construct(public string $name, public string|null $phone)
    {
        //
    }
}
