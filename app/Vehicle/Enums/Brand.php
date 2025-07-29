<?php

namespace App\Vehicle\Enums;

use Filament\Support\Contracts\HasLabel;

enum Brand : string implements HasLabel
{
    case YAMAHA = 'YAMAHA';

    case HONDA = 'HONDA';

    case SUZUKI = 'SUZUKI';

    case KAWASAKI = 'KAWASAKI';

    case KTM = 'KTM';

    case DUCATI = 'DUCATI';

    case HARLEY_DAVIDSON = 'HARLEY_DAVIDSON';

    case BMW = 'BMW';

    case PIAGGIO = 'PIAGGIO';

    case TRIUMPH = 'TRIUMPH';

    case VESPA = 'VESPA';

    case APRILIA = 'APRILIA';

    case VIAR = 'VIAR';

    case KANZEN = 'KANZEN';

    /**
     * @return string|null
     */
    public function getLabel() : ?string
    {
        return str($this->value)->replace('_', ' ');
    }
}
