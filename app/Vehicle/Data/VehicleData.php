<?php

namespace App\Vehicle\Data;

use Spatie\LaravelData\Data;

class VehicleData extends Data
{
    public string $plate;

    public string|null $brand;

    public string|null $model;
}
