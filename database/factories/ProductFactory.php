<?php

namespace Database\Factories;

use App\Models\Shop;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Database\Eloquent\Factories\Factory;

class ProductFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Product::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name' => $this->faker->word,
            'description' => $this->faker->sentence,
            'shop_id' => Shop::first() ?: Shop::factory(),
            'category_id' => Category::leafsOnly()->first() ?: Category::factory(),
            'price' => $price = rand(10, 90),
            'has_discount' => $hasDiscount = $this->faker->boolean,
            'offer_price' => $hasDiscount ? ($price / 2) : null,
            'quantity' => rand(10, 100),
            'colors' => [
                [
                    'hex' => $this->faker->hexColor,
                    'name' => $this->faker->colorName,
                ],
                [
                    'hex' => $this->faker->hexColor,
                    'name' => $this->faker->colorName,
                ],
                [
                    'hex' => $this->faker->hexColor,
                    'name' => $this->faker->colorName,
                ],
            ],
            'sizes' => [
                [
                    'size' => 'XS',
                ],
                [
                    'size' => 'S',
                ],
                [
                    'size' => 'MD',
                ],
                [
                    'size' => 'LG',
                ],
                [
                    'size' => 'XL',
                ],
                [
                    'size' => '2XL',
                ],
            ],
        ];
    }
}
