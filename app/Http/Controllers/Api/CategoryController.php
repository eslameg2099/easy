<?php

namespace App\Http\Controllers\Api;

use App\Models\Category;
use Illuminate\Routing\Controller;
use App\Http\Resources\SelectResource;
use App\Http\Resources\CategoryResource;
use App\Http\Resources\NestedSelectResource;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class CategoryController extends Controller
{
    use AuthorizesRequests, ValidatesRequests;

    /**
     * Display a listing of the categories.
     *
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function index()
    {
        $categories = Category::filter()->parentsOnly()->withCount('children')->simplePaginate();

        return CategoryResource::collection($categories);
    }

    /**
     * Display the specified category.
     *
     * @param \App\Models\Category $category
     * @return \App\Http\Resources\CategoryResource
     */
    public function show(Category $category)
    {
        return new CategoryResource(
            $category->load([
                'children' => function ($query) {
                    $query->withCount('children');
                },
            ])
                ->loadCount('children')
        );
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function select()
    {
        $categories = Category::filter()->parentsOnly()->simplePaginate();

        return NestedSelectResource::collection($categories);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function select2()
    {
        
        $categories = Category::filter()->parentsOnly()->simplePaginate();

        return SelectResource::collection($categories);
    }

    /**
     * Display a listing of the resource.
     *
     * @param \App\Models\Category $category
     * @return \App\Http\Resources\NestedSelectResource
     */
    public function selectShow(Category $category)
    {
        return new NestedSelectResource($category->load('children'));
    }
}
