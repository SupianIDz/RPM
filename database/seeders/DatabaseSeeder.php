<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Product\Imports\ProductsImport;
use Illuminate\Database\Seeder;
use Maatwebsite\Excel\Facades\Excel;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run() : void
    {
        $this->call([
            UnitSeeder::class,
            UserSeeder::class,
        ]);

        Excel::import(new ProductsImport, __DIR__ . '/../products.xlsx');
    }
}
