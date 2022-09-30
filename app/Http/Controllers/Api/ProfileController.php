<?php

namespace App\Http\Controllers\Api;

use App\Models\Shop;
use App\Models\Delegate;
use Illuminate\Support\Arr;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB;
use App\Http\Resources\ShopResource;
use Illuminate\Support\Facades\Hash;
use App\Events\UpdateDelegateLocation;
use App\Http\Resources\ProductResource;
use App\Http\Requests\Api\ProfileRequest;
use Illuminate\Validation\ValidationException;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use App\Models\User;

class ProfileController extends Controller
{
    use AuthorizesRequests, ValidatesRequests;

    /**
     * Display the authenticated user resource.
     *
     * @return \Illuminate\Http\Resources\Json\JsonResource
     */
    public function show()
    {
        return auth()->user()->getResource();
    }

    /**
     * Update the authenticated user profile.
     *
     * @param \App\Http\Requests\Api\ProfileRequest $request
     * @return \Illuminate\Http\Resources\Json\JsonResource
     */
    public function update(ProfileRequest $request)
    {
        
    $user = auth()->user();
       
      
    /** @var \App\Models\User $user */
    if ($user->isShopOwner()) {
        $this->updateShopOwnerProfile($request)->getResource();
    }
    if ($user->isDelegate()) {
        $this->updateDelegateProfile($request)->getResource();
    } else {
        
        $user->update(Arr::except($request->allWithHashedPassword(), ['phone']));

    }
  
    $user->refresh();

    $user->cities()->sync($user->city->getModelWithParents());

    $user->uploadFile('avatar', 'avatars');


    return $user->refresh()->getResource();

       
    }


   

    /**
     * Update the shop owner profile.
     *
     * @param $request
     * @throws \Spatie\MediaLibrary\MediaCollections\Exceptions\FileDoesNotExist
     * @throws \Spatie\MediaLibrary\MediaCollections\Exceptions\FileIsTooBig
     * @throws \Throwable
     * @return \App\Models\ShopOwner
     */
    protected function updateShopOwnerProfile($request)
    {
        DB::beginTransaction();

        /** @var \App\Models\ShopOwner $shopOwner */
        $shopOwner = auth()->user();

        $shopOwner
            ->fill(Arr::except($request->allWithHashedPassword(), 'phone'))
            ->save();

        $shop = tap($shopOwner->shop)->update($request->prefixedWith('shop_'));

        $shop->uploadFile('shop_logo', 'logo');

        $shop->uploadFile('shop_banner', 'banner');
        $shop->address=$request->address;
        $shop->save();

        DB::commit();

        return $shopOwner->load('shop');
    }

    /**
     * Update the delegate profile.
     *
     * @param $request
     * @throws \Spatie\MediaLibrary\MediaCollections\Exceptions\FileDoesNotExist
     * @throws \Spatie\MediaLibrary\MediaCollections\Exceptions\FileIsTooBig
     * @throws \Throwable
     * @return \App\Models\Delegate
     */
    protected function updateDelegateProfile($request)
    {
        DB::beginTransaction();

        /** @var \App\Models\Delegate $delegate */
        $delegate = auth()->user();

        $delegate
            ->fill(Arr::except($request->allWithHashedPassword(), 'phone'))
            ->save();

        $delegate->uploadFile('national_front_image', 'national_front_image');
        $delegate->uploadFile('national_back_image', 'national_back_image');
        $delegate->uploadFile('vehicle_image', 'vehicle_image');

        DB::commit();

        return $delegate;
    }

    public function shop(Shop $shop = null)
    {
        if (! $shop) {
            $shop = auth()->user()->shop;
        }

        $data = [];

        if (($products = $shop->products()->latest()->limit(5)->get()) && $products->count()) {
            $data[] = [
                'title' => __('احدث المنتجات'),
                'data' => ProductResource::collection($shop->products()->latest()->limit(5)->get()),
            ];
        }
        if (($products = $shop->products()->offers()->limit(5)->get()) && $products->count()) {
            $data[] = [
                'title' => __('اخر العروض'),
                'data' => ProductResource::collection($shop->products()->offers()->limit(5)->get()),
            ];
        }
        if (($products = $shop->products()->mostSeller()->limit(5)->get()) && $products->count()) {
            $data[] = [
                'title' => __('الاكثر مبيعاً'),
                'data' => ProductResource::collection($shop->products()->mostSeller()->limit(5)->get()),
            ];
        }

        return response()->json([
            'shop' => new ShopResource($shop),
            'data' => $data,
        ]);
    }

    /**
     * Update the delegate's location.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function updateLocation(Request $request)
    {
        $request->validate([
            'lat' => ['required', 'regex:/^[-]?(([0-8]?[0-9])\.(\d+))|(90(\.0+)?)$/'],
            'lng' => ['required', 'regex:/^[-]?((((1[0-7][0-9])|([0-9]?[0-9]))\.(\d+))|180(\.0+)?)$/'],
        ], [], trans('delegates.attributes'));

        $request->user()->forceFill($request->only('lat', 'lng'))->save();

        broadcast(new UpdateDelegateLocation($request->user()))->toOthers();

        return response()->json([
            'message' => 'Updated',
        ]);
    }

    /**
     * Update the delegate's location.
     *
     * @param \App\Models\Delegate $delegate
     * @return \Illuminate\Http\JsonResponse
     */
    public function getLocation(Delegate $delegate)
    {
        return response()->json([
            'lat' => (float) $delegate->lat,
            'lng' => (float) $delegate->lng,
        ]);
    }
}
