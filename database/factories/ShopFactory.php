<?php

namespace Database\Factories;

use App\Models\Category;
use App\Models\Shop;
use App\Models\ShopOwner;
use Illuminate\Database\Eloquent\Factories\Factory;

class ShopFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Shop::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'user_id' => ShopOwner::first() ?: ShopOwner::factory(),
            'category_id' => Category::first() ?: Category::factory(),
            'name' => $this->faker->word,
            'description' => $this->faker->sentence,
        ];
    }
}
