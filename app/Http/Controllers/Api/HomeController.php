<?php

namespace App\Http\Controllers\Api;

use App\Models\Category;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\CategoryResource;
use App\Http\Resources\CategoryOffersResource;

class HomeController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function __invoke(Request $request)
    {
        $offers = [];

        $categories = Category::where('display_in_home', true)->paginate();

        foreach ($categories as $category) {
            $category->load([
                'products' => function ($builder) {
                    $builder->offersFirst()->limit(5)->get();
                },
            ]);
        }

        return CategoryOffersResource::collection($categories)->additional([
            'slider' => home_slider(),
            'categories' => CategoryResource::collection(Category::parentsOnly()->inRandomOrder()->paginate()),
        ]);
    }
}
