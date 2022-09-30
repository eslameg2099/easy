<?php

namespace App\Http\Controllers\Api;

use App\Models\Product;
use Illuminate\Http\Request;
use App\Events\ProductLocked;
use App\Events\ProductCreated;
use App\Events\ProductUpdated;
use Illuminate\Routing\Controller;
use App\Http\Resources\ReviewResource;
use App\Http\Resources\SelectResource;
use App\Http\Resources\ProductResource;
use App\Http\Requests\Api\ProductRequest;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Support\Facades\Log;

class ProductController extends Controller
{
    use AuthorizesRequests, ValidatesRequests;

    /**
     * Create ProductController Instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth:sanctum')->only([
            'myProducts',
            'toggleLock',
            'review',
            'store',
            'update',
            'favorite',
            'getFavorite',
        ]);
    }

    /**
     * Display a listing of the products.
     *
     * @throws \Illuminate\Auth\Access\AuthorizationException
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function myProducts()
    {
      //  $this->authorize('create', Product::class);

        $products = auth()->user()->shop->products()->filter()->simplePaginate();
        return ProductResource::collection($products);
    }

    /**
     * Display a listing of the products.
     *
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function index()
    {
        $products = Product::filter()->simplePaginate();

        return ProductResource::collection($products);
    }

    /**
     * Display the specified product.
     *
     * @param \App\Models\Product $product
     * @return \App\Http\Resources\ProductResource
     */
    public function show(Product $product)
    {
        $product->load([
            'reviews' => function ($query) {
                $query->latest()->limit(3);
            },
        ]);

        return new ProductResource($product);
    }

    /**
     * Store the newly created product to the storage.
     *
     * @param \App\Http\Requests\Api\ProductRequest $request
     * @return \App\Http\Resources\ProductResource
     */
    public function store(ProductRequest $request)
    {
        /** @var Product $product */
        $product = $request->user()->shop->products()->create($request->all());

        $product->uploadFile('images');

  
        broadcast(new ProductCreated($product))->toOthers();

        return new ProductResource($product);
    }

    /**
     * Update the specified product in storage.
     *
     * @param \App\Http\Requests\Api\ProductRequest $request
     * @param \App\Models\Product $product
     * @return \App\Http\Resources\ProductResource
     */
    public function update(ProductRequest $request, Product $product)
    {
        $this->authorize('update', $product);

        $product->update($request->all());

        $product->uploadFile('images');

        broadcast(new ProductUpdated($product))->toOthers();

        return new ProductResource($product);
    }

    /**
     * Lock & Unlock the given product.
     *
     * @param \App\Models\Product $product
     * @return \App\Http\Resources\ProductResource
     */
    public function toggleLock(Product $product)
    {
        $this->authorize('update', $product);

        if ($product->locked()) {
            broadcast(new ProductLocked($product->markAsUnLocked()))->toOthers();

            return new ProductResource($product);
        }

        broadcast(new ProductLocked($product->markAsLocked()))->toOthers();

        return new ProductResource($product);
    }

    /**
     * Review the given product.
     *
     * @param \App\Models\Product $product
     * @param \Illuminate\Http\Request $request
     * @return \App\Http\Resources\ProductResource
     */
    public function review(Product $product, Request $request)
    {
        $request->validate([
          
            'rate' => 'required|numeric|between:1,5',
        ]);
        if($request->comment == null)
        {
            $request->comment = "";
        }

        $product->review($request->rate, $request->comment);

        return new ProductResource($product->refresh());
    }

    /**
     * Get all the product's reviews.
     *
     * @param \App\Models\Product $product
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function reviews(Product $product)
    {
        $reviews = $product->reviews()->latest()->simplePaginate();

        return ReviewResource::collection($reviews)->additional([
            'product' => new ProductResource($product),
        ]);
    }

    /**
     * Get all the product's reviews.
     *
     * @param \App\Models\Product $product
     * @return \App\Http\Resources\ProductResource
     */
    public function favorite(Product $product)
    {
        $product->toggleFavorite(auth()->id());

        return new ProductResource($product->refresh());
    }

    /**
     * Get all the product's reviews.
     *
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function getFavorite()
    {
        $products = Product::whereHas('favorites', function ($builder) {
            $builder->where('user_id', auth()->id());
        })->simplePaginate();

        return ProductResource::collection($products);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function select()
    {
        $products = Product::filter()->simplePaginate();

        return SelectResource::collection($products);
    }
}
