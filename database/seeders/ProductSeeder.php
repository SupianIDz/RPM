<?php

namespace Database\Seeders;

use App\Brand\Models\Brand;
use App\Product\Models\Category;
use App\Product\Models\Product;
use App\Product\Models\Unit;
use Illuminate\Database\Eloquent\Factories\Sequence;
use Illuminate\Database\Seeder;
use Illuminate\Support\Collection;

class ProductSeeder extends Seeder
{
    /**
     * @return void
     */
    public function run() : void
    {
        $this
            ->call([
                UnitSeeder::class,
                BrandSeeder::class,
                CategorySeeder::class,
            ]);

        $state = new Sequence(function (Sequence $sequence) {
            return [
                'unit_id'     => Unit::all()->random(),
                'brand_id'    => Brand::all()->random(),
                'category_id' => Category::all()->random(),
            ];
        });

        foreach ($this->products() as $product) {
            Product::factory()->state($state)->create([
                'name' => $product,
            ]);
        }
    }

    private function products() : Collection
    {
        return
            collect([
                'Kampas Rem Depan',
                'Kampas Rem Belakang',
                'Piringan Cakram',
                'Master Rem',
                'Selang Rem',
                'Minyak Rem',
                'Kaliper Rem',
                'Kampas Kopling',
                'Per Kopling',
                'Kampas Ganda',
                'V-Belt',
                'Roller CVT',
                'Grease CVT',
                'Pulley Depan',
                'Pulley Belakang',
                'Kabel Kopling',
                'Kabel Gas',
                'Kabel Rem',
                'Busi',
                'Koil',
                'CDI',
                'Spul',
                'Regulator',
                'Saklar On/Off',
                'Kunci Kontak',
                'Relay Starter',
                'Dinamo Starter',
                'Aki Basah',
                'Aki Kering',
                'Lampu Depan',
                'Lampu Belakang',
                'Lampu Sein',
                'Lampu Rem',
                'Lampu Speedometer',
                'Lampu LED',
                'Spedometer Digital',
                'Spedometer Analog',
                'Gear Depan',
                'Gear Belakang',
                'Rantai',
                'Rantai Set',
                'Oli Mesin',
                'Oli Gardan',
                'Oli Shock',
                'Filter Oli',
                'Filter Udara',
                'Filter Bensin',
                'Tangki Bensin',
                'Selang Bensin',
                'Karburator',
                'Injector',
                'Fuel Pump',
                'Seal Klep',
                'Per Klep',
                'Klep In',
                'Klep Out',
                'Noken As',
                'Rocker Arm',
                'Piston',
                'Ring Piston',
                'Seher',
                'Blok Mesin',
                'Silinder Head',
                'Packing Head',
                'Packing Blok',
                'Stang Seher',
                'Crankshaft',
                'Magnet',
                'Laher Kruk As',
                'Laher Roda',
                'Velg Jari-jari',
                'Velg Racing',
                'Ban Dalam',
                'Ban Luar',
                'Pentil Ban',
                'Shockbreaker Depan',
                'Shockbreaker Belakang',
                'Segitiga Shock',
                'Segitiga Dudukan',
                'Knalpot',
                'Silincer',
                'Leher Knalpot',
                'Gasket Knalpot',
                'Footstep',
                'Brake Pedal',
                'Kick Starter',
                'Handle Rem',
                'Handle Kopling',
                'Spion',
                'Stang',
                'Kunci Stang',
                'Grip Stang',
                'Switch Rem',
                'Switch Kopling',
                'Fender Depan',
                'Fender Belakang',
                'Body Cover',
                'Tutup Aki',
                'Tutup Tangki',
                'Dek Kaki',
                'Dek Bawah',
                'Cover CVT',
                'Box Filter',
                'Box Accu',
                'Bagasi Jok',
                'Jok Motor',
                'Engsel Jok',
                'Bracket Jok',
                'Bracket Lampu',
                'Bracket Spion',
                'Rangka Motor',
                'Footstep Bracket',
                'Step Belakang',
                'Karet Step',
                'Karet Engine Mounting',
                'Standar Tengah',
                'Standar Samping',
                'Pegas Standar',
                'As Roda Depan',
                'As Roda Belakang',
                'Mur Roda',
                'Mur Velg',
                'Kunci Roda',
                'Tool Kit',
                'Kunci Busi',
                'Gemuk Roda',
                'Carbon Cleaner',
                'Engine Flush',
                'Coolant Radiator',
                'Radiator',
                'Kipas Radiator',
                'Thermostat',
                'Selang Radiator',
                'Tutupan Radiator',
                'Garnish Body',
                'Logo Motor',
                'Stiker Body',
                'Kabel Body',
                'Fuse / Sekring',
                'Box Sekring',
                'Sensor Suhu',
                'Sensor Kecepatan',
                'Sensor Injeksi',
                'Switch Netral',
                'Switch Rem Belakang',
                'Switch Tuas',
                'Speed Gear',
                'Speed Sensor',
                'Chain Adjuster',
                'Tensioner Rantai',
                'Tensioner Klep',
                'Timing Chain',
                'Gasket CVT',
                'Seal As Kruk',
                'Seal As Roda',
                'Bearing Kruk As',
                'Baut Busi',
                'Baut CVT',
                'Baut Blok Mesin',
                'Mur Shock',
                'Pen Roda',
            ]);
    }
}
