<?php

namespace Database\Seeders;

use App\Models\Shop;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        foreach (Category::where('display_in_home', true)->get() as $category) {
            $products = Product::factory([
                'name' => 'ترابيزة تلفزيون خشبية',
                'category_id' => $category,
                'description' => '<ul>
<li>ارتفاع: 42 سم</li>
<li>العرض: 90 سم</li>
<li>العمق: 30 سم</li>
<li>نوع: طاولة تلفاز</li>
<li>وزن المنتج: 10 كغ</li>
<li>المنتج قابل للتعديل: لا</li>
</ul>',
            ])->count(10)->create();

            foreach ($products as $product) {
                $product->addMedia(public_path('images/product/01.png'))
                    ->preservingOriginal()
                    ->toMediaCollection();
            }
        }
    }
}
