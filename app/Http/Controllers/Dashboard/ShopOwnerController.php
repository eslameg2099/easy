<?php

namespace App\Http\Controllers\Dashboard;

use App\Models\ShopOwner;
use Illuminate\Routing\Controller;
use App\Http\Requests\Dashboard\ShopOwnerRequest;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;


class ShopOwnerController extends Controller
{
    use AuthorizesRequests, ValidatesRequests;

    /**
     * ShopOwnerController constructor.
     */
    public function __construct()
    {
        $this->authorizeResource(ShopOwner::class, 'shop_owner');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $shopOwners = ShopOwner::filter()->latest()->paginate();

        return view('dashboard.accounts.shop_owners.index', compact('shopOwners'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('dashboard.accounts.shop_owners.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \App\Http\Requests\Dashboard\ShopOwnerRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(ShopOwnerRequest $request)
    {
        $shopOwner = ShopOwner::create($request->allWithHashedPassword());

        $shopOwner->setType($request->type);

        $shopOwner->addAllMediaFromTokens();

        flash()->success(trans('shop_owners.messages.created'));

        return redirect()->route('dashboard.shop_owners.show', $shopOwner);
    }

    /**
     * Display the specified resource.
     *
     * @param \App\Models\ShopOwner $shopOwner
     * @return \Illuminate\Http\Response
     */
    public function show(ShopOwner $shopOwner)
    {
        return view('dashboard.accounts.shop_owners.show', compact('shopOwner'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param \App\Models\ShopOwner $shopOwner
     * @return \Illuminate\Http\Response
     */
    public function edit(ShopOwner $shopOwner)
    {
        return view('dashboard.accounts.shop_owners.edit', compact('shopOwner'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \App\Http\Requests\Dashboard\ShopOwnerRequest $request
     * @param \App\Models\ShopOwner $shopOwner
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(ShopOwnerRequest $request, ShopOwner $shopOwner)
    {
        $shopOwner->update($request->allWithHashedPassword());

        $shopOwner->setType($request->type);

        $shopOwner->addAllMediaFromTokens();

        flash()->success(trans('shop_owners.messages.updated'));

        return redirect()->route('dashboard.shop_owners.show', $shopOwner);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Models\ShopOwner $shopOwner
     * @throws \Exception
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(ShopOwner $shopOwner)
    {
        $shopOwner->delete();

        flash()->success(trans('shop_owners.messages.deleted'));

        return redirect()->route('dashboard.shop_owners.index');
    }

    /**
     * Display a listing of the trashed resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function trashed()
    {
        $this->authorize('viewAnyTrash', ShopOwner::class);

        $shopOwners = ShopOwner::onlyTrashed()->paginate();

        return view('dashboard.accounts.shop_owners.trashed', compact('shopOwners'));
    }

    /**
     * Display the specified trashed resource.
     *
     * @param \App\Models\ShopOwner $shopOwner
     * @return \Illuminate\Http\Response
     */
    public function showTrashed(ShopOwner $shopOwner)
    {
        $this->authorize('viewTrash', $shopOwner);

        return view('dashboard.accounts.shop_owners.show', compact('shopOwner'));
    }

    /**
     * Restore the trashed resource.
     *
     * @param \App\Models\ShopOwner $shopOwner
     * @return \Illuminate\Http\RedirectResponse
     */
    public function restore(ShopOwner $shopOwner)
    {
        $this->authorize('restore', $shopOwner);

        $shopOwner->restore();

        flash()->success(trans('shop_owners.messages.restored'));

        return redirect()->route('dashboard.shop_owners.trashed');
    }

    /**
     * Force delete the specified resource from storage.
     *
     * @param \App\Models\ShopOwner $shopOwner
     * @throws \Exception
     * @return \Illuminate\Http\RedirectResponse
     */
    public function forceDelete(ShopOwner $shopOwner)
    {
        $this->authorize('forceDelete', $shopOwner);

        $shopOwner->forceDelete();

        flash()->success(trans('shop_owners.messages.deleted'));

        return redirect()->route('dashboard.shop_owners.trashed');
    }

    public function active($id)
    {
        $Customer = ShopOwner::findorfail($id);
        $Customer->phone_verified_at =now();;
        $Customer->save();
        flash()->success('تم بنجاح');
        return redirect()->back();
    }


    public function disactive($id)
    {
        $Customer = ShopOwner::findorfail($id);
        $Customer->phone_verified_at =null;
        $Customer->save();
        flash()->success('تم بنجاح');
        return redirect()->back();


    }
}
