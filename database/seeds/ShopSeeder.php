<?php

namespace Database\Seeders;

use App\Models\Shop;
use App\Models\ShopOwner;
use Illuminate\Database\Seeder;

class ShopSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        foreach (ShopOwner::all() as $merchant) {
            $shop = Shop::factory()->create([
                'name' => 'فيتشر للأثاث',
                'description' => 'أثاث منزلي ومكتبي',
                'user_id' => $merchant,
            ]);

            $shop->addMedia(public_path('images/shop/logo.png'))
                ->preservingOriginal()
                ->toMediaCollection('logo');

            $shop->addMedia(public_path('images/shop/banner.png'))
                ->preservingOriginal()
                ->toMediaCollection('banner');
        }
    }
}
