<?php

namespace Database\Factories;

use App\Models\User;
use App\Models\Report;
use App\Models\ShopOrder;
use Illuminate\Database\Eloquent\Factories\Factory;

class ReportFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Report::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'user_id' => User::factory(),
            'shop_order_id' => ShopOrder::factory(),
            'message' => $this->faker->sentence,
            'read_at' => $this->faker->randomElement([null, now()]),
        ];
    }
}
