<?php

namespace App\Http\Controllers\Api;

use App\Models\Address;
use Illuminate\Routing\Controller;
use App\Http\Resources\SelectResource;
use App\Http\Resources\AddressResource;
use App\Http\Requests\Api\AddressRequest;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class AddressController extends Controller
{
    use AuthorizesRequests, ValidatesRequests;

    /**
     * Create Address Controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth:sanctum');

        $this->authorizeResource(Address::class, 'address');
    }

    /**
     * Display a listing of the addresses.
     *
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function index()
    {
        $addresses = request()->user()->addresses()->filter()->simplePaginate();

        return AddressResource::collection($addresses);
    }

    /**
     * Display the specified address.
     *
     * @param \App\Models\Address $address
     * @return \App\Http\Resources\AddressResource
     */
    public function show(Address $address)
    {
        return new AddressResource($address);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function select()
    {
        $addresses = Address::filter()->simplePaginate();

        return SelectResource::collection($addresses);
    }

    /**
     * Store the newly created address to the storage.
     *
     * @param \App\Http\Requests\Api\AddressRequest $request
     * @return \App\Http\Resources\AddressResource
     */
    public function store(AddressRequest $request)
    {
        return new AddressResource(
            $request->user()
                ->addresses()
                ->create($request->validated())
        );
    }

    /**
     * Update the specified address in the storage.
     *
     * @param \App\Http\Requests\Api\AddressRequest $request
     * @param \App\Models\Address $address
     * @return \App\Http\Resources\AddressResource
     */
    public function update(AddressRequest $request, Address $address)
    {
        return new AddressResource(
            tap($address)->update($request->validated())
        );
    }

    /**
     * Delete the specified address from the storage.
     *
     * @param \App\Models\Address $address
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(Address $address)
    {
        $address->delete();

        return response()->json([
            'message' => trans('addresses.messages.deleted'),
        ]);
    }
}
