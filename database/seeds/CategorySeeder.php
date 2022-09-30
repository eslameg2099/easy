<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Support\Arr;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->seed($this->categories());
    }

    /**
     * Seed the categories and subcategories.
     *
     * @param array $categories
     * @param mixed $parent
     * @return void
     */
    public function seed($categories = [], $parent = null)
    {
        foreach ($categories as $category) {
            $data = array_merge(
                Arr::except($category, ['subcategories', 'image', 'banner']),
                [
                    'parent_id' => $parent,
                ]
            );

            $model = Category::factory()->create($data);

            if (isset($category['image'])) {
                $model->addMedia(__DIR__.'/images/categories/'.$category['image'])
                ->preservingOriginal()
                ->toMediaCollection();
            }
            if (isset($category['banner'])) {
                $model->addMedia(__DIR__.'/images/categories/'.$category['banner'])
                ->preservingOriginal()
                ->toMediaCollection('banner');
            }

            if (isset($category['subcategories'])) {
                $this->seed($category['subcategories'], $model);
            }
        }
    }

    /**
     * List of 3 levels categories.
     *
     * @return array[]
     */
    public function categories()
    {
        return json_decode(file_get_contents(__DIR__.'/categories.json'), 1);
    }
}
