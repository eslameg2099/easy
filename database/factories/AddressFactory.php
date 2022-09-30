<?php

namespace Database\Factories;

use App\Models\City;
use App\Models\User;
use App\Models\Address;
use App\Models\Customer;
use Illuminate\Database\Eloquent\Factories\Factory;

class AddressFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Address::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name' => $this->faker->word,
            'user_id' => Customer::first() ?: Customer::factory(),
            'city_id' => City::factory(),
            'address' => $this->faker->sentence,
            'lat' => $this->faker->latitude,
            'lng' => $this->faker->longitude,
        ];
    }
}
