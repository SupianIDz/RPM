<?php

namespace App\Vehicle\Observers;

use App\Vehicle\Models\Vehicle;

class VehicleObserver
{
    /**
     * @param  Vehicle $vehicle
     * @return void
     */
    public function creating(Vehicle $vehicle) : void
    {
        $vehicle->plate = str($vehicle->plate)->upper()->replaceMatches('/[^A-Z0-9]/', '');
    }
}
