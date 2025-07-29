<?php

namespace App\Order\Enums;

use Filament\Support\Contracts\HasIcon;
use Filament\Support\Contracts\HasLabel;

enum Type : string implements HasLabel, HasIcon
{
    case PRODUCT = 'PRODUCT';

    case SERVICE = 'SERVICE';

    case TURNING = 'TURNING';

    case BENZENE = 'BENZENE';

    /**
     * @return string|null
     */
    public function getIcon() : ?string
    {
        return match ($this) {
            self::PRODUCT => 'lucide-shopping-bag',
            self::SERVICE => 'lucide-briefcase',
            self::TURNING => 'lucide-refresh-cw',
            self::BENZENE => 'lucide-car',
        };
    }

    /**
     * @return string|null
     */
    public function getLabel() : ?string
    {
        return match ($this) {
            self::PRODUCT => 'PRODUCT',
            self::SERVICE => 'SERVICE',
            self::TURNING => 'BUBUT',
            self::BENZENE => 'BENSOL',
        };
    }
}
