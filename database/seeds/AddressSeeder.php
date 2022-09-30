<?php

namespace Database\Seeders;

use App\Models\Address;
use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Factories\Sequence;

class AddressSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Address::factory()
            ->state(
                new Sequence(
                    ['name' => 'Home', 'address' => 'Almandarah Street.'],
                    ['name' => 'Work', 'address' => 'Loran City.'],
                )
            )
            ->count(2)
            ->create();
    }
}
