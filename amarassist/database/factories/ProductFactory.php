<?php

namespace Database\Factories;

use App\Models\Product;
use Illuminate\Database\Eloquent\Factories\Factory;
use Faker\Generator as Faker;

class ProductFactory extends Factory
{
    protected $model = Product::class;

    public function definition()
    {
        return [
            'title' => $this->faker->word,
            'sale_price' => $this->faker->randomFloat(2, 10, 100),
            'cost' => $this->faker->randomFloat(2, 5, 50),
            'description' => $this->faker->paragraph,
            'images' => json_encode([$this->faker->imageUrl, $this->faker->imageUrl]),
        ];
    }
}
