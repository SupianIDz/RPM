<?php

namespace App\Order\Data;

use App\Customer\Data\CustomerData;
use App\Order\Enums\Payment;
use App\Vehicle\Data\VehicleData;
use Spatie\LaravelData\Data;

class OrderData extends Data
{
    public string $invoice;

    public float $amount;

    public float $discount;

    public Payment $payment;

    public string $status;

    public string $date;

    public VehicleData $vehicle;

    public CustomerData $customer;
}
