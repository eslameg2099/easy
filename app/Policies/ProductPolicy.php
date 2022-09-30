<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Product;
use Illuminate\Database\Eloquent\SoftDeletes;
use Laraeast\LaravelSettings\Facades\Settings;
use Illuminate\Auth\Access\HandlesAuthorization;

class ProductPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any products.
     *
     * @param \App\Models\User|null $user
     * @return mixed
     */
    public function viewAny(User $user)
    {
        return $user->isAdmin() || $user->hasPermissionTo('manage.products');
    }

    /**
     * Determine whether the user can view the product.
     *
     * @param \App\Models\User|null $user
     * @param \App\Models\Product $product
     * @return mixed
     */
    public function view(User $user, Product $product)
    {
        return $user->isAdmin() || $user->hasPermissionTo('manage.products');
    }

    /**
     * Determine whether the user can create products.
     *
     * @param \App\Models\User $user
     * @return mixed
     */
    public function create(User $user)
    {
        return $user->isAdmin()
            || $user->hasPermissionTo('manage.products')
            || $user->isShopOwner();
    }

    /**
     * Determine whether the user can update the product.
     *
     * @param \App\Models\User $user
     * @param \App\Models\Product $product
     * @return mixed
     */
    public function update(User $user, Product $product)
    {
        return (
                $user->isAdmin()
                || $user->hasPermissionTo('manage.products')
                || ($user->isShopOwner() && $user->products()->find($product->id))
            ) && ! $this->trashed($product);
    }

    /**
     * Determine whether the user can delete the product.
     *
     * @param \App\Models\User $user
     * @param \App\Models\Product $product
     * @return mixed
     */
    public function delete(User $user, Product $product)
    {
        return ($user->isAdmin() || $user->hasPermissionTo('manage.products')) && ! $this->trashed($product);
    }

    /**
     * Determine whether the user can view trashed products.
     *
     * @param \App\Models\User $user
     * @return mixed
     */
    public function viewAnyTrash(User $user)
    {
        return ($user->isAdmin() || $user->hasPermissionTo('manage.products')) && $this->hasSoftDeletes();
    }

    /**
     * Determine whether the user can view the trashed product.
     *
     * @param \App\Models\User|null $user
     * @param \App\Models\Product $product
     * @return mixed
     */
    public function viewTrash(User $user, Product $product)
    {
        return $this->view($user, $product) && $product->trashed();
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param \App\Models\User $user
     * @param \App\Models\Product $product
     * @return mixed
     */
    public function restore(User $user, Product $product)
    {
        return ($user->isAdmin() || $user->hasPermissionTo('manage.products')) && $this->trashed($product);
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param \App\Models\User $user
     * @param \App\Models\Product $product
     * @return mixed
     */
    public function forceDelete(User $user, Product $product)
    {
        return ($user->isAdmin() || $user->hasPermissionTo('manage.products'))
            && $this->trashed($product)
            && Settings::get('delete_forever');
    }

    /**
     * Determine wither the given product is trashed.
     *
     * @param $product
     * @return bool
     */
    public function trashed($product)
    {
        return $this->hasSoftDeletes() && method_exists($product, 'trashed') && $product->trashed();
    }

    /**
     * Determine wither the model use soft deleting trait.
     *
     * @return bool
     */
    public function hasSoftDeletes()
    {
        return in_array(
            SoftDeletes::class,
            array_keys((new \ReflectionClass(Product::class))->getTraits())
        );
    }
}
