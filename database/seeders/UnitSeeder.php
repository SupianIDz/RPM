<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Collection;

class UnitSeeder extends Seeder
{
    /**
     * @return void
     */
    public function run() : void
    {
        $this->units()->each(function (string $symbol, string $unit) {
            \App\Product\Models\Unit::create([
                'name'   => $unit,
                'symbol' => $symbol,
            ]);
        });
    }

    /**
     * @return Collection
     */
    private function units() : Collection
    {
        return
            collect([
                'pcs'    => 'pcs',      // pieces - satuan umum
                'set'    => 'set',      // untuk kampas rem, rantai set, dll
                'liter'  => 'L',        // pelumas, oli
                'ml'     => 'ml',       // cairan kecil, seperti coolant
                'gram'   => 'g',        // gemuk (grease), pembersih
                'kg'     => 'kg',       // barang berat, aki besar
                'roll'   => 'roll',     // kabel, isolasi, selang
                'meter'  => 'm',        // selang, kabel, tali gas, dll
                'botol'  => 'botol',    // cairan pembersih
                'kaleng' => 'kaleng',   // cat, pelumas semprot
                'tube'   => 'tube',     // pasta, lem
                'pak'    => 'pak',      // kemasan isi banyak
                'box'    => 'box',      // dus isi banyak (misal 50 pcs busi)
                'buah'   => 'buah',     // sama dengan pcs, tapi kadang dipakai di nota manual
                'lembar' => 'lembar',   // stiker, gasket
                'can'    => 'can',      // jerigen pelumas ukuran besar (4L, 5L)
                'unit'   => 'unit',     // barang besar (kompresor, dongkrak)
            ]);
    }
}
