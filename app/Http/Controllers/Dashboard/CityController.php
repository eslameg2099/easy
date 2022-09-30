<?php

namespace App\Http\Controllers\Dashboard;

use App\Models\City;
use Illuminate\Routing\Controller;
use App\Http\Requests\Dashboard\CityRequest;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class CityController extends Controller
{
    use AuthorizesRequests, ValidatesRequests;

    /**
     * CityController constructor.
     */
    public function __construct()
    {
        $this->authorizeResource(City::class, 'city');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $cities = City::where('parent_id',null)->filter()->paginate();
        return view('dashboard.cities.index', compact('cities'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $cities = City::get();
        return view('dashboard.cities.create', compact('cities'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \App\Http\Requests\Dashboard\CityRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(CityRequest $request)
    {
        $city = City::create($request->all());

        flash()->success(trans('cities.messages.created'));

        return redirect()->route('dashboard.cities.show', $city);
    }

    /**
     * Display the specified resource.
     *
     * @param \App\Models\City $city
     * @return \Illuminate\Http\Response
     */
    public function show(City $city)
    {
        $cities =   City::where('parent_id',$city->id)->get();
        $count  =   count($city->parents);
        return view('dashboard.cities.show', compact('city','cities','count'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param \App\Models\City $city
     * @return \Illuminate\Http\Response
     */
    public function edit(City $city)
    {
        $cities = City::get();

        return view('dashboard.cities.edit', compact('city','cities'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \App\Http\Requests\Dashboard\CityRequest $request
     * @param \App\Models\City $city
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(CityRequest $request, City $city)
    {
        $city->update($request->all());

        flash()->success(trans('cities.messages.updated'));

        return redirect()->route('dashboard.cities.show', $city);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Models\City $city
     * @throws \Exception
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(City $city)
    {
        $city->delete();

        flash()->success(trans('cities.messages.deleted'));

        return redirect()->route('dashboard.cities.index');
    }

    /**
     * Display a listing of the trashed resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function trashed()
    {
        $this->authorize('viewAnyTrash', City::class);

        $cities = City::onlyTrashed()->paginate();

        return view('dashboard.cities.trashed', compact('cities'));
    }

    /**
     * Display the specified trashed resource.
     *
     * @param \App\Models\City $city
     * @return \Illuminate\Http\Response
     */
    public function showTrashed(City $city)
    {
        $this->authorize('viewTrash', $city);

        return view('dashboard.cities.show', compact('city'));
    }

    /**
     * Restore the trashed resource.
     *
     * @param \App\Models\City $city
     * @return \Illuminate\Http\RedirectResponse
     */
    public function restore(City $city)
    {
        $this->authorize('restore', $city);

        $city->restore();

        flash()->success(trans('cities.messages.restored'));

        return redirect()->route('dashboard.cities.trashed');
    }

    /**
     * Force delete the specified resource from storage.
     *
     * @param \App\Models\City $city
     * @throws \Exception
     * @return \Illuminate\Http\RedirectResponse
     */
    public function forceDelete(City $city)
    {
        $this->authorize('forceDelete', $city);

        $city->forceDelete();

        flash()->success(trans('cities.messages.deleted'));

        return redirect()->route('dashboard.cities.trashed');
    }

    public function active($id)
    {
        $City = City::findorfail($id);
        $City->active = '1';
        $City->save();
        flash()->success('تم بنجاح');
        return redirect()->back();
    }


    public function disactive($id)
    {
        $City = City::findorfail($id);
        $City->active = '0';
        $City->save();
        flash()->success('تم بنجاح');
        return redirect()->back();
    }
}
