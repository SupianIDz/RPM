<?php

namespace App\Order\Enums;

use Filament\Support\Contracts\HasColor;
use Filament\Support\Contracts\HasIcon;

enum Payment : string implements HasColor, HasIcon
{
    case CASH = 'CASH';

    case TRANSFER = 'TRANSFER';

    case MARKETPLACE = 'MARKETPLACE';

    /**
     * @return string|array|null
     */
    public function getColor() : string|array|null
    {
        return match ($this) {
            self::CASH        => 'success',
            self::TRANSFER    => 'warning',
            self::MARKETPLACE => 'info',
        };
    }

    /**
     * @return string|null
     */
    public function getIcon() : ?string
    {
        return match ($this) {
            self::CASH        => 'lucide-credit-card',
            self::TRANSFER    => 'lucide-banknote',
            self::MARKETPLACE => 'lucide-shopping-cart',
        };
    }
}
