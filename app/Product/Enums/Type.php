<?php

namespace App\Product\Enums;

use Filament\Support\Contracts\HasLabel;

enum Type : string implements HasLabel
{
    case SERVICE = 'SERVICE';

    case PRODUCT = 'PRODUCT';

    /**
     * @return string|null
     */
    public function getLabel() : ?string
    {
        return match ($this) {
            self::SERVICE => 'JASA',
            self::PRODUCT => 'PRODUK',
        };
    }
}
