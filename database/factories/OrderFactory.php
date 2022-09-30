<?php

namespace Database\Factories;

use App\Models\User;
use App\Models\Order;
use App\Models\Address;
use App\Models\Customer;
use Illuminate\Database\Eloquent\Factories\Factory;

class OrderFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Order::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'user_id' => Customer::first() ?: Customer::factory(),
            'address_id' => Address::first() ?: Address::factory(),
            'status' => $this->faker->randomElement([
                Order::PENDING_STATUS,
                Order::IN_PROGRESS_STATUS,
                Order::DELIVERING_STATUS,
                Order::DELIVERED_STATUS,
            ]),
            'sub_total' => rand(10, 500),
            'discount' => rand(10, 100),
            'shipping_cost' => rand(10, 20),
        ];
    }
}
