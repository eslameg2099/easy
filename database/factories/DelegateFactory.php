<?php

namespace Database\Factories;

use App\Models\City;
use App\Models\Delegate;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Factories\Factory;

class DelegateFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Delegate::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name' => $this->faker->name,
            'email' => $this->faker->unique()->safeEmail,
            'phone' => $this->faker->unique()->phoneNumber,
            'phone_verified_at' => now(),
            'email_verified_at' => now(),
            'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
            'remember_token' => Str::random(10),
            'city_id' => City::first() ?: City::factory(),
            'national_id' => $this->faker->word,
            'vehicle_type' => $this->faker->word,
            'vehicle_model' => $this->faker->word,
            'vehicle_number' => $this->faker->word,
            'is_available' => true,
            'is_approved' => true,
            'lat' => $this->faker->latitude,
            'lng' => $this->faker->longitude,
        ];
    }

    /**
     * Configure the model factory.
     *
     * @return $this
     */
    public function configure()
    {
        return $this->afterCreating(function (Delegate $user) {
            Delegate::withoutEvents(function () use ($user) {
                $user->forceFill([
                    'phone_verified_at' => now(),
                ])->save();
            });
            $user->addMedia(public_path('images/national_front.png'))->preservingOriginal()->toMediaCollection('national_front_image');
            $user->addMedia(public_path('images/national_back.png'))->preservingOriginal()->toMediaCollection('national_back_image');
            $user->addMedia(public_path('images/car.jpg'))->preservingOriginal()->toMediaCollection('vehicle_image');
        });
    }
}
