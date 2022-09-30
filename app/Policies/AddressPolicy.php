<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Address;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Auth\Access\HandlesAuthorization;

class AddressPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any addresses.
     *
     * @param \App\Models\User|null $user
     * @return mixed
     */
    public function viewAny(User $user)
    {
        return true;
    }

    /**
     * Determine whether the user can view the address.
     *
     * @param \App\Models\User|null $user
     * @param \App\Models\Address $address
     * @return mixed
     */
    public function view(User $user, Address $address)
    {
        return $user->isAdmin() || $user->is($address->user) || $user->hasPermissionTo('manage.addresses');
    }

    /**
     * Determine whether the user can create addresses.
     *
     * @param \App\Models\User $user
     * @return mixed
     */
    public function create(User $user)
    {
        return true;
    }

    /**
     * Determine whether the user can update the address.
     *
     * @param \App\Models\User $user
     * @param \App\Models\Address $address
     * @return mixed
     */
    public function update(User $user, Address $address)
    {
        return (
                $user->isAdmin()
                || $user->is($address->user)
                || $user->hasPermissionTo('manage.addresses')
            )
            && ! $this->trashed($address);
    }

    /**
     * Determine whether the user can delete the address.
     *
     * @param \App\Models\User $user
     * @param \App\Models\Address $address
     * @return mixed
     */
    public function delete(User $user, Address $address)
    {
        return (
                $user->isAdmin()
                || $user->is($address->user)
                || $user->hasPermissionTo('manage.addresses')
            )
            && ! $this->trashed($address);
    }

    /**
     * Determine whether the user can view trashed addresses.
     *
     * @param \App\Models\User $user
     * @return mixed
     */
    public function viewAnyTrash(User $user)
    {
        return ($user->isAdmin() || $user->hasPermissionTo('manage.addresses')) && $this->hasSoftDeletes();
    }

    /**
     * Determine whether the user can view the trashed address.
     *
     * @param \App\Models\User|null $user
     * @param \App\Models\Address $address
     * @return mixed
     */
    public function viewTrash(User $user, Address $address)
    {
        return $this->view($user, $address) && $address->trashed();
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param \App\Models\User $user
     * @param \App\Models\Address $address
     * @return mixed
     */
    public function restore(User $user, Address $address)
    {
        return ($user->isAdmin() || $user->hasPermissionTo('manage.addresses')) && $this->trashed($address);
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param \App\Models\User $user
     * @param \App\Models\Address $address
     * @return mixed
     */
    public function forceDelete(User $user, Address $address)
    {
        return ($user->isAdmin() && $user->isNot($address) || $user->hasPermissionTo('manage.addresses')) && $this->trashed($address);
    }

    /**
     * Determine wither the given address is trashed.
     *
     * @param $address
     * @return bool
     */
    public function trashed($address)
    {
        return $this->hasSoftDeletes() && method_exists($address, 'trashed') && $address->trashed();
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
            array_keys((new \ReflectionClass(Address::class))->getTraits())
        );
    }
}
