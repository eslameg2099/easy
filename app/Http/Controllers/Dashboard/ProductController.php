<?php

namespace App\Http\Controllers\Dashboard;

use App\Models\Product;
use App\Events\ProductLocked;
use Illuminate\Routing\Controller;
use App\Http\Requests\Dashboard\ProductRequest;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Laraeast\LaravelSettings\Facades\Settings;

class ProductController extends Controller
{
    use AuthorizesRequests, ValidatesRequests;

    /**
     * ProductController constructor.
     */
    public function __construct()
    {
        $this->authorizeResource(Product::class, 'product');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $products = Product::filter()->latest()->paginate();

        return view('dashboard.products.index', compact('products'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
       
        return view('dashboard.products.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \App\Http\Requests\Dashboard\ProductRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(ProductRequest $request)
    {
        $request->merge([
            'colors' => $request->colors ?: [],
            'sizes' => $request->sizes ?: [],
        ]);

        $product = Product::create($request->all());

        $product->addAllMediaFromTokens();

        flash()->success(trans('products.messages.created'));

        return redirect()->route('dashboard.products.show', $product);
    }

    /**
     * Display the specified resource.
     *
     * @param \App\Models\Product $product
     * @return \Illuminate\Http\Response
     */
    public function show(Product $product)
    {
        return view('dashboard.products.show', compact('product'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param \App\Models\Product $product
     * @return \Illuminate\Http\Response
     */
    public function edit(Product $product)
    {
        return view('dashboard.products.edit', compact('product'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \App\Http\Requests\Dashboard\ProductRequest $request
     * @param \App\Models\Product $product
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(ProductRequest $request, Product $product)
    {
        $request->merge([
            'colors' => $request->colors ?: [],
            'sizes' => $request->sizes ?: [],
        ]);

        $product->update($request->all());

        $product->addAllMediaFromTokens();

        flash()->success(trans('products.messages.updated'));

        return redirect()->route('dashboard.products.show', $product);
    }

    /**
     * Lock & Unlock the given product.
     *
     * @param \App\Models\Product $product
     * @throws \Illuminate\Auth\Access\AuthorizationException
     * @return \Illuminate\Http\RedirectResponse
     */
    public function toggleLock(Product $product)
    {
        $this->authorize('update', $product);

        if ($product->locked()) {
            broadcast(new ProductLocked($product->markAsUnLocked()))->toOthers();

            return back();
        }

        broadcast(new ProductLocked($product->markAsLocked()))->toOthers();

        return back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Models\Product $product
     * @throws \Exception
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Product $product)
    {
        $product->delete();

        flash()->success(trans('products.messages.deleted'));

        return redirect()->route('dashboard.products.index');
    }

    /**
     * Display a listing of the trashed resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function trashed()
    {
        $this->authorize('viewAnyTrash', Product::class);

        $products = Product::onlyTrashed()->paginate();

        return view('dashboard.products.trashed', compact('products'));
    }

    /**
     * Display the specified trashed resource.
     *
     * @param \App\Models\Product $product
     * @return \Illuminate\Http\Response
     */
    public function showTrashed(Product $product)
    {
        $this->authorize('viewTrash', $product);

        return view('dashboard.products.show', compact('product'));
    }

    /**
     * Restore the trashed resource.
     *
     * @param \App\Models\Product $product
     * @return \Illuminate\Http\RedirectResponse
     */
    public function restore(Product $product)
    {
        $this->authorize('restore', $product);

        $product->restore();

        flash()->success(trans('products.messages.restored'));

        return redirect()->route('dashboard.products.trashed');
    }

    /**
     * Force delete the specified resource from storage.
     *
     * @param \App\Models\Product $product
     * @throws \Exception
     * @return \Illuminate\Http\RedirectResponse
     */
    public function forceDelete(Product $product)
    {
        $this->authorize('forceDelete', $product);

        $product->forceDelete();

        flash()->success(trans('products.messages.deleted'));

        return redirect()->route('dashboard.products.trashed');
    }
}
