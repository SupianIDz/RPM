<?php

namespace App\Recap\Data;

use Illuminate\Support\Carbon;
use Spatie\LaravelData\Attributes\MapInputName;
use Spatie\LaravelData\Data;
use Spatie\LaravelData\Mappers\SnakeCaseMapper;

#[MapInputName(SnakeCaseMapper::class)]
class RecapData extends Data
{
    public Carbon $period;

    public string $type;

    public int $totalOrder;

    public float $totalValue;
}
