<?php

namespace App\Policies;

use App\Models\User;
use App\Models\ShopOwner;
use Illuminate\Database\Eloquent\SoftDeletes;
use Laraeast\LaravelSettings\Facades\Settings;
use Illuminate\Auth\Access\HandlesAuthorization;

class ShopOwnerPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any shop owners.
     *
     * @param \App\Models\User $user
     * @return mixed
     */
    public function viewAny(User $user)
    {
        return $user->isAdmin() || $user->hasPermissionTo('manage.shop_owners');
    }

    /**
     * Determine whether the user can view the shop owner.
     *
     * @param \App\Models\User $user
     * @param \App\Models\ShopOwner $shopOwner
     * @return mixed
     */
    public function view(User $user, ShopOwner $shopOwner)
    {
        return $user->isAdmin() || $user->is($shopOwner) || $user->hasPermissionTo('manage.shop_owners');
    }

    /**
     * Determine whether the user can create shop owners.
     *
     * @param \App\Models\User $user
     * @return mixed
     */
    public function create(User $user)
    {
        return $user->isAdmin() || $user->hasPermissionTo('manage.shop_owners');
    }

    /**
     * Determine whether the user can update the shop owner.
     *
     * @param \App\Models\User $user
     * @param \App\Models\ShopOwner $shopOwner
     * @return mixed
     */
    public function update(User $user, ShopOwner $shopOwner)
    {
        return ($user->isAdmin() || $user->is($shopOwner) || $user->hasPermissionTo('manage.shop_owners')) && ! $this->trashed($shopOwner);
    }

    /**
     * Determine whether the user can update the type of the shop owner.
     *
     * @param \App\Models\User $user
     * @param \App\Models\ShopOwner $shopOwner
     * @return mixed
     */
    public function updateType(User $user, ShopOwner $shopOwner)
    {
        return $user->isAdmin() && $user->isNot($shopOwner) || $user->hasPermissionTo('manage.shop_owners');
    }

    /**
     * Determine whether the user can delete the shop owner.
     *
     * @param \App\Models\User $user
     * @param \App\Models\ShopOwner $shopOwner
     * @return mixed
     */
    public function delete(User $user, ShopOwner $shopOwner)
    {
        return ($user->isAdmin() && $user->isNot($shopOwner) || $user->hasPermissionTo('manage.shop_owners')) && ! $this->trashed($shopOwner);
    }

    /**
     * Determine whether the user can view trashed shop owners.
     *
     * @param \App\Models\User $user
     * @return mixed
     */
    public function viewAnyTrash(User $user)
    {
        return ($user->isAdmin() || $user->hasPermissionTo('manage.shop_owners')) && $this->hasSoftDeletes();
    }

    /**
     * Determine whether the user can view trashed shop owner.
     *
     * @param \App\Models\User $user
     * @param \App\Models\ShopOwner $shopOwner
     * @return mixed
     */
    public function viewTrash(User $user, ShopOwner $shopOwner)
    {
        return $this->view($user, $shopOwner) && $this->trashed($shopOwner);
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param \App\Models\User $user
     * @param \App\Models\ShopOwner $shopOwner
     * @return mixed
     */
    public function restore(User $user, ShopOwner $shopOwner)
    {
        return ($user->isAdmin() || $user->hasPermissionTo('manage.shop_owners')) && $this->trashed($shopOwner);
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param \App\Models\User $user
     * @param \App\Models\ShopOwner $shopOwner
     * @return mixed
     */
    public function forceDelete(User $user, ShopOwner $shopOwner)
    {
        return (
                $user->isAdmin()
                && $user->isNot($shopOwner)
                || $user->hasPermissionTo('$manage.shop_owners')
            )
            && $this->trashed($shopOwner)
            && Settings::get('delete_forever');
    }

    /**
     * Determine wither the given shop owner is trashed.
     *
     * @param $shopOwner
     * @return bool
     */
    public function trashed($shopOwner)
    {
        return $this->hasSoftDeletes() && method_exists($shopOwner, 'trashed') && $shopOwner->trashed();
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
            array_keys((new \ReflectionClass(ShopOwner::class))->getTraits())
        );
    }
}
