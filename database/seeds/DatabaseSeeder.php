<?php

namespace Database\Seeders;

use App\Models\City;
use App\Models\User;
use App\Models\Admin;
use App\Models\Customer;
use App\Models\Delegate;
use App\Models\ShopOwner;
use App\Models\Supervisor;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->command->call('media-library:clean');

        $this->call(RolesAndPermissionsSeeder::class);

        $city = City::factory()->create([
            'name' => 'أدم',
        ]);

        $admin = Admin::factory()->createOne([
            'name' => 'Admin',
            'email' => 'admin@demo.com',
            'city_id' => $city,
        ]);

        /** @var Supervisor $supervisor */
        $supervisor = Supervisor::factory()->createOne([
            'name' => 'Supervisor',
            'email' => 'supervisor@demo.com',
            'city_id' => $city,
        ]);
        $supervisor->givePermissionTo([
            'manage.customers',
            'manage.feedback',
        ]);

        $shopOwner = ShopOwner::factory()->createOne([
            'name' => 'Shop Owner 1',
            'phone' => '511111111',
            'city_id' => $city,
        ]);
        $shopOwner = ShopOwner::factory()->createOne([
            'name' => 'Shop Owner 2',
            'phone' => '522222222',
            'city_id' => $city,
        ]);
        $shopOwner = ShopOwner::factory()->createOne([
            'name' => 'Shop Owner 3',
            'phone' => '533333333',
            'city_id' => $city,
        ]);

        $delegate = Delegate::factory()->createOne([
            'name' => 'Delegate 1',
            'phone' => '544444444',
            'city_id' => $city,
        ]);

        $delegate = Delegate::factory()->createOne([
            'name' => 'Delegate 2',
            'phone' => '555555555',
            'city_id' => $city,
        ]);

        $delegate = Delegate::factory()->createOne([
            'name' => 'Delegate 3',
            'phone' => '566666666',
            'city_id' => $city,
        ]);

        $customer = Customer::factory()->createOne([
            'name' => 'Customer 1',
            'phone' => '577777777',
            'city_id' => $city,
        ]);

        $customer = Customer::factory()->createOne([
            'name' => 'Customer 2',
            'phone' => '588888888',
            'city_id' => $city,
        ]);

        $customer = Customer::factory()->createOne([
            'name' => 'Customer 3',
            'phone' => '599999999',
            'city_id' => $city,
        ]);

        $this->call([
            DummyDataSeeder::class,
        ]);

        $this->command->table(['Name', 'Email', 'Phone', 'Password', 'Type'], [
            [$admin->name, $admin->email, $admin->phone, 'password', User::ADMIN_TYPE],
            [
                $supervisor->name,
                $supervisor->email,
                $supervisor->phone,
                'password',
                User::SUPERVISOR_TYPE,
            ],
            [
                'Shop Owner 1',
                '---',
                '511111111',
                'password',
                User::SHOP_OWNER_TYPE,
            ],
            [
                'Shop Owner 2',
                '---',
                '522222222',
                'password',
                User::SHOP_OWNER_TYPE,
            ],
            [
                'Shop Owner 3',
                '---',
                '533333333',
                'password',
                User::SHOP_OWNER_TYPE,
            ],
            [
                'Delegate 1',
                '---',
                '544444444',
                'password',
                User::DELEGATE_TYPE,
            ],
            [
                'Delegate 2',
                '---',
                '555555555',
                'password',
                User::DELEGATE_TYPE,
            ],
            [
                'Delegate 3',
                '---',
                '566666666',
                'password',
                User::DELEGATE_TYPE,
            ],
            [
                'Customer 1',
                '---',
                '577777777',
                'password',
                User::CUSTOMER_TYPE,
            ],
            [
                'Customer 2',
                '---',
                '588888888',
                'password',
                User::CUSTOMER_TYPE,
            ],
            [
                'Customer 3',
                '---',
                '599999999',
                'password',
                User::CUSTOMER_TYPE,
            ],
        ]);
    }
}
