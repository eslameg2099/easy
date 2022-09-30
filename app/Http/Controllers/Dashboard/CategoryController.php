<?php

namespace App\Http\Controllers\Dashboard;

use App\Models\Category;
use Illuminate\Routing\Controller;
use App\Http\Requests\Dashboard\CategoryRequest;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class CategoryController extends Controller
{
    use AuthorizesRequests, ValidatesRequests;

    /**
     * CategoryController constructor.
     */
    public function __construct()
    {
        $this->authorizeResource(Category::class, 'category');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $categories = Category::filter()->parentsOnly()->withCount('children')->latest()->paginate();

        return view('dashboard.categories.index', compact('categories'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('dashboard.categories.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \App\Http\Requests\Dashboard\CategoryRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(CategoryRequest $request)
    {
        $category = Category::create($request->all());

        $category->addAllMediaFromTokens();

        flash()->success(trans('categories.messages.created'));

        return redirect()->route('dashboard.categories.show', $category->parent ?: $category);
    }

    /**
     * Display the specified resource.
     *
     * @param \App\Models\Category $category
     * @return \Illuminate\Http\Response
     */
    public function show(Category $category)
    {
        $children = $category->children()->filter()->withCount('children')->paginate();

        return view('dashboard.categories.show', compact('category', 'children'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param \App\Models\Category $category
     * @return \Illuminate\Http\Response
     */
    public function edit(Category $category)
    {
        return view('dashboard.categories.edit', compact('category'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \App\Http\Requests\Dashboard\CategoryRequest $request
     * @param \App\Models\Category $category
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(CategoryRequest $request, Category $category)
    {
        $category->update($request->all());

        $category->addAllMediaFromTokens();

        flash()->success(trans('categories.messages.updated'));

        return redirect()->route('dashboard.categories.show', $category->parent ?: $category);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Models\Category $category
     * @throws \Exception
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Category $category)
    {
        $parent = $category->parent;

        $category->delete();

        flash(trans('categories.messages.deleted'));

        if ($parent) {
            return redirect()->route('dashboard.categories.show', $parent);
        }

        return redirect()->route('dashboard.categories.index');
    }

    /**
     * Display a listing of the trashed resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function trashed()
    {
        $this->authorize('viewAnyTrash', Category::class);

        $categories = Category::onlyTrashed()->paginate();

        return view('dashboard.categories.trashed', compact('categories'));
    }

    /**
     * Display the specified trashed resource.
     *
     * @param \App\Models\Category $category
     * @return \Illuminate\Http\Response
     */
    public function showTrashed(Category $category)
    {
        $this->authorize('viewTrash', $category);

        $children = $category->children()->filter()->withCount('children')->paginate();

        return view('dashboard.categories.show', compact('category', 'children'));
    }

    /**
     * Restore the trashed resource.
     *
     * @param \App\Models\Category $category
     * @return \Illuminate\Http\RedirectResponse
     */
    public function restore(Category $category)
    {
        $this->authorize('restore', $category);

        $category->restore();

        flash()->success(trans('categories.messages.restored'));

        return redirect()->route('dashboard.categories.trashed');
    }

    /**
     * Force delete the specified resource from storage.
     *
     * @param \App\Models\Category $category
     * @throws \Exception
     * @return \Illuminate\Http\RedirectResponse
     */
    public function forceDelete(Category $category)
    {
        $this->authorize('forceDelete', $category);

        $category->forceDelete();

        flash()->success(trans('categories.messages.deleted'));

        return redirect()->route('dashboard.categories.trashed');
    }
}
