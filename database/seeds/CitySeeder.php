<?php

namespace Database\Seeders;

use App\Models\City;
use App\Models\Customer;
use App\Models\Delegate;
use App\Models\ShopOwner;
use Illuminate\Database\Seeder;
use Database\Seeders\Sequences\CitySequence;

class CitySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        City::factory()
            ->count(72)
            ->has(ShopOwner::factory())
            ->has(Delegate::factory())
            ->has(Customer::factory())
            ->state(CitySequence::make())
            ->create();
    }
}
