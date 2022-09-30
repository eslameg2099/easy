<?php

namespace App\Http\Controllers\Api;

use App\Models\Shop;
use Illuminate\Routing\Controller;
use App\Http\Resources\ShopResource;
use App\Http\Resources\SelectResource;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class ShopController extends Controller
{
    use AuthorizesRequests, ValidatesRequests;

    /**
     * Display a listing of the shops.
     *
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function index()
    {
        $shops = Shop::filter()->simplePaginate();

        return ShopResource::collection($shops);
    }

    /**
     * Display the specified shop.
     *
     * @param \App\Models\Shop $shop
     * @return \App\Http\Resources\ShopResource
     */
    public function show(Shop $shop)
    {
        return new ShopResource($shop);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function select()
    {
        $shops = Shop::filter()->simplePaginate();

        return SelectResource::collection($shops);
    }
}
