<?php

namespace App\Http\Controllers\Dashboard;

use App\Models\Order;
use App\Models\Shop;
use Illuminate\Routing\Controller;
use App\Http\Requests\Dashboard\ShopRequest;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

use App\Traits\NotificationsTrait;
use App\Models\Notification as NotificationModel;
use App\Models\ShopOwner;

class ShopController extends Controller
{
    use AuthorizesRequests, ValidatesRequests;

    /**
     * ShopController constructor.
     */
    public function __construct()
    {
        $this->authorizeResource(Shop::class, 'shop');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $shops = Shop::filter()->latest()->paginate();

        return view('dashboard.shops.index', compact('shops'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function create($id)
    { 
          $ShopOwner = ShopOwner::findorfail($id);
          return view('dashboard.shops.create', compact('ShopOwner'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \App\Http\Requests\Dashboard\ShopRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(ShopRequest $request)
    {
        $shop = Shop::create($request->all());

        $shop->addAllMediaFromTokens();

        flash()->success(trans('shops.messages.created'));

        return redirect()->route('dashboard.shops.show', $shop);
    }

    /**
     * Display the specified resource.
     *
     * @param \App\Models\Shop $shop
     * @return \Illuminate\Http\Response
     */
    public function show(Shop $shop)
    {
        $balance = $shop->orders()->where('status', Order::DELIVERED_STATUS)->whereNull('collected_at')->sum('total');

        $collected = $shop->collects()->latest('date')->simplePaginate();

        return view('dashboard.shops.show', compact('shop', 'balance', 'collected'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param \App\Models\Shop $shop
     * @return \Illuminate\Http\Response
     */
    public function edit(Shop $shop)
    {
        $ShopOwner = ShopOwner::findorfail($shop->user_id);
        return view('dashboard.shops.edit', compact('shop','ShopOwner'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \App\Http\Requests\Dashboard\ShopRequest $request
     * @param \App\Models\Shop $shop
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(ShopRequest $request, Shop $shop)
    {
        $shop->update($request->all());

        $shop->addAllMediaFromTokens();

        flash()->success(trans('shops.messages.updated'));

        return redirect()->route('dashboard.shops.show', $shop);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Models\Shop $shop
     * @throws \Exception
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Shop $shop)
    {
        $shop->delete();

        flash()->success(trans('shops.messages.deleted'));

        return redirect()->route('dashboard.shops.index');
    }

    /**
     * Display a listing of the trashed resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function trashed()
    {
        $this->authorize('viewAnyTrash', Shop::class);

        $shops = Shop::onlyTrashed()->paginate();

        return view('dashboard.shops.trashed', compact('shops'));
    }

    /**
     * Display the specified trashed resource.
     *
     * @param \App\Models\Shop $shop
     * @return \Illuminate\Http\Response
     */
    public function showTrashed(Shop $shop)
    {
        $this->authorize('viewTrash', $shop);

        return view('dashboard.shops.show', compact('shop'));
    }

    /**
     * Restore the trashed resource.
     *
     * @param \App\Models\Shop $shop
     * @return \Illuminate\Http\RedirectResponse
     */
    public function restore(Shop $shop)
    {
        $this->authorize('restore', $shop);

        $shop->restore();

        flash()->success(trans('shops.messages.restored'));

        return redirect()->route('dashboard.shops.trashed');
    }

    /**
     * Force delete the specified resource from storage.
     *
     * @param \App\Models\Shop $shop
     * @throws \Exception
     * @return \Illuminate\Http\RedirectResponse
     */
    public function forceDelete(Shop $shop)
    {
        $this->authorize('forceDelete', $shop);

        $shop->forceDelete();

        flash()->success(trans('shops.messages.deleted'));

        return redirect()->route('dashboard.shops.trashed');
    }
    /**
     * Collect the shop balance.
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function collect(Shop $shop)
    {
        $balance = $shop->orders()->where('status', Order::DELIVERED_STATUS)->whereNull('collected_at')->sum('total');
        $title = 'اشعار تحصيل اموال ' ;
        $body ='تم تحصبل مبلغ'.$balance ;
        NotificationsTrait::send($shop->owner,$title,$body,NotificationModel::Due_SHOP_TYPE,$shop->owner->id);
        $shop->collect();

        return back();
    }
}
