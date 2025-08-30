<?php

namespace App\Product\Imports;

use App\Category\Models\Category;
use App\Product\Models\Product;
use App\Unit\Models\Unit;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\ToModel;
use Throwable;

class ProductsImport implements ToModel
{
    protected string|null $unit = null;

    /**
     * array:6 [
     *      0 => 1
     *      1 => "RPM-1629"
     *      2 => "BREKET NGRT DEPAN RR300"
     *      3 => 500000
     *      4 => 2
     *      5 => "Accessories"
     * ]
     *
     * @param  array $row
     * @return Product
     * @throws Throwable
     */
    public function model(array $row) : Product
    {
        if (is_null($this->unit)) {
            $this->unit = Unit::where('symbol', 'pcs')->first()->getKey();
        }

        return
            DB::transaction(function () use ($row) {
                $product = Product::create([
                    'code'        => $row[1],
                    'name'        => $row[2],
                    'stock'       => $row[4],
                    'unit_id'     => $this->unit,
                    'category_id' => $this->category($row[5]),
                ]);

                $product->price()->create([
                    'cogs'   => 0,
                    'amount' => $row[3],
                ]);

                return $product;
            });
    }

    /**
     * @param  string|null $category
     * @return string|null
     */
    private function category(string|null $category) : string|null
    {
        if (is_null($category)) {
            return null;
        }

        return
            Category::firstOrCreate(['slug' => str($category)->slug()], [
                'name' => $category,
            ])
                ->getKey();
    }
}
