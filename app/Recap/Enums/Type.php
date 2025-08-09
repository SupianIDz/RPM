<?php

namespace App\Recap\Enums;

enum Type : string
{
    case CASH = 'CASH';

    case TRANSFER = 'TRANSFER';

    case MARKETPLACE = 'MARKETPLACE';
}
