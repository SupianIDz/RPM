<?php

namespace App\User\Enums;

use Filament\Support\Contracts\HasColor;
use Filament\Support\Contracts\HasIcon;
use Filament\Support\Contracts\HasLabel;

enum Role : string implements HasLabel, HasIcon, HasColor
{
    case ADMIN = 'ADMIN';

    case CASHIER = 'CASHIER';

    case INVENTORY = 'INVENTORY';

    case MECHANIC = 'MECHANIC';

    /**
     * @return string
     */
    public function getLabel() : string
    {
        return match ($this) {
            self::ADMIN     => 'ADMIN',
            self::CASHIER   => 'CASHIER',
            self::INVENTORY => 'INVENTORY',
            self::MECHANIC  => 'MECHANIC',
        };
    }

    /**
     * @return string
     */
    public function getIcon() : string
    {
        return match ($this) {
            self::ADMIN     => 'lucide-shield-check',
            self::CASHIER   => 'lucide-credit-card',
            self::INVENTORY => 'lucide-box',
            self::MECHANIC  => 'lucide-wrench',
        };
    }

    /**
     * @return string
     */
    public function getColor() : string
    {
        return match ($this) {
            self::ADMIN     => 'primary',
            self::CASHIER   => 'success',
            self::INVENTORY => 'warning',
            self::MECHANIC  => 'gray',
        };
    }
}
