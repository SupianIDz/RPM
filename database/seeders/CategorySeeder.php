<?php

namespace Database\Seeders;

use App\Product\Models\Category;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    public function run() : void
    {
        $categories = [
            'Pelumas & Cairan' => [
                'Oli Mesin',
                'Oli Gardan',
                'Minyak Rem',
                'Air Radiator / Coolant',
                'Carbon Cleaner',
                'Grease',
                'Cairan Pembersih',
            ],

            'Sparepart & Komponen Mesin' => [
                'Busi',
                'Filter Udara',
                'Filter Oli',
                'Kampas Rem',
                'Rantai & Gear Set',
                'CVT Kit',
                'Set Kopling',
                'Bearing',
                'Gasket',
                'Shockbreaker',
            ],

            'Kelistrikan' => [
                'Aki / Accu',
                'Bohlam',
                'Flasher',
                'CDI / ECU',
            ],

            'Ban & Kaki-Kaki' => [
                'Ban Tubeless',
                'Ban Biasa + Ban Dalam',
                'Velg',
            ],

            'Perlengkapan Bengkel' => [
                'Baut & Mur',
                'Kunci / Tool Kit',
            ],

            'Aksesori & Tambahan' => [
                'Spion',
                'Jok Motor',
                'Sarung Tangan / Raincoat',
            ],

            'Lain-lain' => [],
        ];

        foreach ($categories as $name => $subcategories) {
            $category = Category::create([
                'name' => $name,
            ]);

            foreach ($subcategories as $subcategory) {
                $category->child()->create([
                    'name' => $subcategory,
                ]);
            }
        }
    }
}
