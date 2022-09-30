<?php

namespace App\Http\Controllers\Dashboard;

use App\Models\Delegate;
use App\Models\Order;
use Illuminate\Routing\Controller;
use App\Http\Requests\Dashboard\DelegateRequest;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

use App\Traits\NotificationsTrait;
use App\Models\Notification as NotificationModel;

class DelegateController extends Controller
{
    use AuthorizesRequests, ValidatesRequests;

    /**
     * DelegateController constructor.
     */
    public function __construct()
    {
        $this->authorizeResource(Delegate::class, 'delegate');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $delegates = Delegate::filter()->latest()->paginate();

        return view('dashboard.accounts.delegates.index', compact('delegates'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('dashboard.accounts.delegates.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \App\Http\Requests\Dashboard\DelegateRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(DelegateRequest $request)
    {
        $delegate = new Delegate();

        $delegate->fill($request->allWithHashedPassword())
            ->forceFill($request->only('is_approved', 'is_available'));

        $delegate->save();

        $delegate->setType($request->type);

        $delegate->addAllMediaFromTokens();

        flash()->success(trans('delegates.messages.created'));

        return redirect()->route('dashboard.delegates.show', $delegate);
    }

    /**
     * Display the specified resource.
     *
     * @param \App\Models\Delegate $delegate
     * @return \Illuminate\Http\Response
     */
    public function show(Delegate $delegate)
    {
        $balance = $delegate->shopOrders()->where('status',
            Order::DELIVERED_STATUS)->whereNull('delegate_collected_at')->sum('total');

        $collected = $delegate->collects()->latest('date')->simplePaginate();

        return view('dashboard.accounts.delegates.show', compact('delegate', 'balance', 'collected'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param \App\Models\Delegate $delegate
     * @return \Illuminate\Http\Response
     */
    public function edit(Delegate $delegate)
    {
        return view('dashboard.accounts.delegates.edit', compact('delegate'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \App\Http\Requests\Dashboard\DelegateRequest $request
     * @param \App\Models\Delegate $delegate
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(DelegateRequest $request, Delegate $delegate)
    {
        $delegate->fill($request->allWithHashedPassword())
            ->forceFill($request->only('is_approved', 'is_available'))
            ->save();

        $delegate->setType($request->type);

        $delegate->addAllMediaFromTokens();

        flash()->success(trans('delegates.messages.updated'));

        return redirect()->route('dashboard.delegates.show', $delegate);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Models\Delegate $delegate
     * @throws \Exception
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Delegate $delegate)
    {
        $delegate->delete();

        flash()->success(trans('delegates.messages.deleted'));

        return redirect()->route('dashboard.delegates.index');
    }

    /**
     * Display a listing of the trashed resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function trashed()
    {
        $this->authorize('viewAnyTrash', Delegate::class);

        $delegates = Delegate::onlyTrashed()->paginate();

        return view('dashboard.accounts.delegates.trashed', compact('delegates'));
    }

    /**
     * Display the specified trashed resource.
     *
     * @param \App\Models\Delegate $delegate
     * @return \Illuminate\Http\Response
     */
    public function showTrashed(Delegate $delegate)
    {
        $this->authorize('viewTrash', $delegate);

        return view('dashboard.accounts.delegates.show', compact('delegate'));
    }

    /**
     * Restore the trashed resource.
     *
     * @param \App\Models\Delegate $delegate
     * @return \Illuminate\Http\RedirectResponse
     */
    public function restore(Delegate $delegate)
    {
        $this->authorize('restore', $delegate);

        $delegate->restore();

        flash()->success(trans('delegates.messages.restored'));

        return redirect()->route('dashboard.delegates.trashed');
    }

    /**
     * Force delete the specified resource from storage.
     *
     * @param \App\Models\Delegate $delegate
     * @throws \Exception
     * @return \Illuminate\Http\RedirectResponse
     */
    public function forceDelete(Delegate $delegate)
    {
        $this->authorize('forceDelete', $delegate);

        $delegate->forceDelete();

        flash()->success(trans('delegates.messages.deleted'));

        return redirect()->route('dashboard.delegates.trashed');
    }

    /**
     * Display the specified order.
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function collect(Delegate $delegate)
    {
        $balance = $delegate->shopOrders()->where('status',
        Order::DELIVERED_STATUS)->whereNull('delegate_collected_at')->sum('total');
        $title = 'اشعار تحصيل اموال ' ;
        $body ='تم تحصبل مبلغ'.$balance ;
        NotificationsTrait::send($delegate,$title,$body,NotificationModel::Due_DELEGATE_TYPE,$delegate->id);
        $delegate->collect();

        return back();
    }

    public function active($id)
    {
        $Customer = Delegate::findorfail($id);
        $Customer->phone_verified_at =now();;
        $Customer->save();
        flash()->success('تم بنجاح');
        return redirect()->back();
    }


    public function disactive($id)
    {
        $Customer = Delegate::findorfail($id);
        $Customer->phone_verified_at =null;
        $Customer->save();
        flash()->success('تم بنجاح');
        return redirect()->back();


    }
}
