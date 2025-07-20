<?php

namespace Database\Factories;

use App\Product\Models\Product;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use Random\RandomException;

/** @mixin Factory<Product> */
class ProductFactory extends Factory
{
    protected $model = Product::class;

    /**
     * @throws RandomException
     */
    public function definition() : array
    {
        return [
            'code'        => strtoupper(Str::random(8)),
            'name'        => $this->faker->words(2, true) . ' ' . ucfirst($this->faker->word),
            'description' => $this->faker->text(),
            'stock'       => random_int(1, 40),
            'active'      => $this->faker->boolean(),
            'created_at'  => now(),
            'updated_at'  => now(),
        ];
    }
}
