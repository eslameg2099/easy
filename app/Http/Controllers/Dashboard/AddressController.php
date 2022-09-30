<?php

namespace App\Http\Controllers\Dashboard;
use App\Models\Customer;

use App\Models\Address;
use Illuminate\Routing\Controller;
use App\Http\Requests\Dashboard\AddressRequest;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class AddressController extends Controller
{
    use AuthorizesRequests, ValidatesRequests;

    /**
     * AddressController constructor.
     */
    public function __construct()
    {
        $this->authorizeResource(Address::class, 'address');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $addresses = Address::filter()->latest()->paginate();

        return view('dashboard.addresses.index', compact('addresses'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($id)
    {
        $Customer = Customer::findorfail($id);
        return view('dashboard.addresses.create', compact('Customer'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \App\Http\Requests\Dashboard\AddressRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(AddressRequest $request)
    {
        $address = Address::create($request->all());

        flash()->success(trans('addresses.messages.created'));

        return redirect()->route('dashboard.addresses.show', $address);
    }

    /**
     * Display the specified resource.
     *
     * @param \App\Models\Address $address
     * @return \Illuminate\Http\Response
     */
    public function show(Address $address)
    {
        
        return view('dashboard.addresses.show', compact('address'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param \App\Models\Address $address
     * @return \Illuminate\Http\Response
     */
    public function edit(Address $address)
    {
        return view('dashboard.addresses.edit', compact('address'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \App\Http\Requests\Dashboard\AddressRequest $request
     * @param \App\Models\Address $address
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(AddressRequest $request, Address $address)
    {
        $address->update($request->all());

        flash()->success(trans('addresses.messages.updated'));

        return redirect()->route('dashboard.addresses.show', $address);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Models\Address $address
     * @throws \Exception
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Address $address)
    {
        $address->delete();

        flash()->success(trans('addresses.messages.deleted'));

        return redirect()->back();
    }

    /**
     * Display a listing of the trashed resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function trashed()
    {
        $this->authorize('viewAnyTrash', Address::class);

        $addresses = Address::onlyTrashed()->paginate();

        return view('dashboard.addresses.trashed', compact('addresses'));
    }

    /**
     * Display the specified trashed resource.
     *
     * @param \App\Models\Address $address
     * @return \Illuminate\Http\Response
     */
    public function showTrashed(Address $address)
    {
        $this->authorize('viewTrash', $address);

        return view('dashboard.addresses.show', compact('address'));
    }

    /**
     * Restore the trashed resource.
     *
     * @param \App\Models\Address $address
     * @return \Illuminate\Http\RedirectResponse
     */
    public function restore(Address $address)
    {
        $this->authorize('restore', $address);

        $address->restore();

        flash()->success(trans('addresses.messages.restored'));

        return redirect()->route('dashboard.addresses.trashed');
    }

    /**
     * Force delete the specified resource from storage.
     *
     * @param \App\Models\Address $address
     * @throws \Exception
     * @return \Illuminate\Http\RedirectResponse
     */
    public function forceDelete(Address $address)
    {
        $this->authorize('forceDelete', $address);

        $address->forceDelete();

        flash()->success(trans('addresses.messages.deleted'));

        return redirect()->route('dashboard.addresses.trashed');
    }
}
