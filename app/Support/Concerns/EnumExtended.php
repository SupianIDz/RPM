<?php

namespace App\Support\Concerns;

use BackedEnum;

trait EnumExtended
{
    /**
     * @param  BackedEnum $enum
     * @return bool
     */
    public function is(BackedEnum $enum) : bool
    {
        return $this === $enum;
    }

    /**
     * @param  BackedEnum $enum
     * @return bool
     */
    public function isNot(BackedEnum $enum) : bool
    {
        return ! $this->is($enum);
    }
}
