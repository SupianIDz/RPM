<?php

namespace App\Order\Enums;

enum Payment : string
{
    case CASH = 'CASH';

    case TRANSFER = 'TRANSFER';

    case MARKETPLACE = 'MARKETPLACE';
}
