<?php

namespace App\Http\Controllers\Api;

use App\Models\User;
use App\Models\Delegate;
use Illuminate\Routing\Controller;
use App\Http\Resources\SelectResource;
use App\Http\Resources\DelegateResource;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use App\Models\Order;

class UserController extends Controller
{
    use AuthorizesRequests, ValidatesRequests;

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function select()
    {
        $users = User::filter()->paginate();
        return SelectResource::collection($users);
    }

    public function selectdelegate($id)
    {
        $users = User::where('type', User::DELEGATE_TYPE)->where('city_id',$id)
       ->paginate();

        return SelectResource::collection($users);
    }

   
    /**
     * Display a listing of the resource.
     *
     * @param \App\Models\Delegate $delegate
     * @return \App\Http\Resources\DelegateResource
     * @deprecated
     */
    public function approve(Delegate $delegate)
    {
        $delegate->forceFill(['is_approved' => ! $delegate->is_approved])->save();

        return new DelegateResource($delegate);
    }
}
