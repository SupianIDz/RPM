<?php

namespace App\Order\Enums;

use App\Support\Concerns\EnumExtended;
use Filament\Support\Contracts\HasIcon;
use Filament\Support\Contracts\HasLabel;
use Illuminate\Contracts\Database\Query\Expression;
use Illuminate\Support\Facades\DB;

enum Type : string implements HasLabel, HasIcon
{
    use EnumExtended;

    case PRODUCT = 'PRODUCT';

    case SERVICE = 'SERVICE';

    case TURNING = 'TURNING';

    case BENZENE = 'BENZENE';

    /**
     * @return Expression
     */
    public function query() : Expression
    {
        return match ($this) {
            self::PRODUCT => DB::raw("CASE WHEN type = 'PRODUCT' THEN amount ELSE 0 END"),
            self::SERVICE => DB::raw("CASE WHEN type = 'SERVICE' THEN amount ELSE 0 END"),
            self::TURNING => DB::raw("CASE WHEN type = 'TURNING' THEN amount ELSE 0 END"),
            self::BENZENE => DB::raw("CASE WHEN type = 'BENZENE' THEN amount ELSE 0 END"),
        };
    }

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
            self::PRODUCT => 'SPARE PART',
            self::SERVICE => 'SERVICE',
            self::TURNING => 'BUBUT',
            self::BENZENE => 'BENSOL',
        };
    }
}
