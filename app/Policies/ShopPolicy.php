<?php

namespace App\Policies;

use App\Models\Shop;
use App\Models\User;
use Illuminate\Database\Eloquent\SoftDeletes;
use Laraeast\LaravelSettings\Facades\Settings;
use Illuminate\Auth\Access\HandlesAuthorization;

class ShopPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any shops.
     *
     * @param \App\Models\User|null $user
     * @return mixed
     */
    public function viewAny(User $user)
    {
        return $user->isAdmin() || $user->hasPermissionTo('manage.shops');
    }

    /**
     * Determine whether the user can view the shop.
     *
     * @param \App\Models\User|null $user
     * @param \App\Models\Shop $shop
     * @return mixed
     */
    public function view(User $user, Shop $shop)
    {
        return $user->isAdmin() || $user->hasPermissionTo('manage.shops');
    }

    /**
     * Determine whether the user can create shops.
     *
     * @param \App\Models\User $user
     * @return mixed
     */
    public function create(User $user)
    {
        return $user->isAdmin() || $user->hasPermissionTo('manage.shops');
    }

    /**
     * Determine whether the user can update the shop.
     *
     * @param \App\Models\User $user
     * @param \App\Models\Shop $shop
     * @return mixed
     */
    public function update(User $user, Shop $shop)
    {
        return ($user->isAdmin() || $user->hasPermissionTo('manage.shops')) && ! $this->trashed($shop);
    }

    /**
     * Determine whether the user can delete the shop.
     *
     * @param \App\Models\User $user
     * @param \App\Models\Shop $shop
     * @return mixed
     */
    public function delete(User $user, Shop $shop)
    {
        return ($user->isAdmin() || $user->hasPermissionTo('manage.shops')) && ! $this->trashed($shop);
    }

    /**
     * Determine whether the user can view trashed shops.
     *
     * @param \App\Models\User $user
     * @return mixed
     */
    public function viewAnyTrash(User $user)
    {
        return ($user->isAdmin() || $user->hasPermissionTo('manage.shops')) && $this->hasSoftDeletes();
    }

    /**
     * Determine whether the user can view the trashed shop.
     *
     * @param \App\Models\User|null $user
     * @param \App\Models\Shop $shop
     * @return mixed
     */
    public function viewTrash(User $user, Shop $shop)
    {
        return $this->view($user, $shop) && $shop->trashed();
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param \App\Models\User $user
     * @param \App\Models\Shop $shop
     * @return mixed
     */
    public function restore(User $user, Shop $shop)
    {
        return ($user->isAdmin() || $user->hasPermissionTo('manage.shops')) && $this->trashed($shop);
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param \App\Models\User $user
     * @param \App\Models\Shop $shop
     * @return mixed
     */
    public function forceDelete(User $user, Shop $shop)
    {
        return (
                $user->isAdmin()
                || $user->hasPermissionTo('manage.shops')
            )
            && $this->trashed($shop)
            && Settings::get('delete_forever');
    }

    /**
     * Determine wither the given shop is trashed.
     *
     * @param $shop
     * @return bool
     */
    public function trashed($shop)
    {
        return $this->hasSoftDeletes() && method_exists($shop, 'trashed') && $shop->trashed();
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
            array_keys((new \ReflectionClass(Shop::class))->getTraits())
        );
    }
}
