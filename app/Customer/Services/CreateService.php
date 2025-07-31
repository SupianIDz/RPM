<?php

namespace App\Customer\Services;

use App\Customer\Models\Customer;

class CreateService
{
    /**
     * @param  string $name
     * @param  string $phone
     * @return Customer
     */
    public function handle(string $name, string $phone) : Customer
    {
        $name = ucwords(strtolower($name));

        return Customer::updateOrCreate(['phone' => $this->sanitize($phone)], [
            'name' => $name,
        ]);
    }

    /**
     * @param  string $number
     * @return string
     */
    protected function sanitize(string $number) : string
    {
        // Remove all non-numeric characters
        $number = preg_replace('/[^0-9]/', '', $number);

        // If it starts with '0', replace it with '62'
        if (str_starts_with($number, '0')) {
            $number = '62' . substr($number, 1);
        }

        // If it starts with '8', assume it's missing '62' and add it
        if (str_starts_with($number, '8')) {
            $number = '62' . $number;
        }

        // If it starts with '620' (e.g. from +62 followed by 08), fix it to '62' + the rest
        if (str_starts_with($number, '620')) {
            $number = '62' . substr($number, 3);
        }

        return $number;
    }
}
