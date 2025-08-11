<?php

namespace App\Support\Concerns;

trait EnumExtended
{
    /**
     * @param  \BackedEnum $enum
     * @return bool
     */
    public function is(\BackedEnum $enum) : bool
    {
        return $this === $enum;
    }
}
