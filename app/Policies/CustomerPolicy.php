<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Customer;
use Illuminate\Database\Eloquent\SoftDeletes;
use Laraeast\LaravelSettings\Facades\Settings;
use Illuminate\Auth\Access\HandlesAuthorization;

class CustomerPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any customers.
     *
     * @param \App\Models\User $user
     * @return mixed
     */
    public function viewAny(User $user)
    {
        return $user->isAdmin() || $user->hasPermissionTo('manage.customers');
    }

    /**
     * Determine whether the user can view the customer.
     *
     * @param \App\Models\User $user
     * @param \App\Models\Customer $customer
     * @return mixed
     */
    public function view(User $user, Customer $customer)
    {
        return $user->isAdmin()
            || $user->is($customer)
            || $user->hasPermissionTo('manage.customers');
    }

    /**
     * Determine whether the user can create customers.
     *
     * @param \App\Models\User $user
     * @return mixed
     */
    public function create(User $user)
    {
        return $user->isAdmin() || $user->hasPermissionTo('manage.customers');
    }

    /**
     * Determine whether the user can update the customer.
     *
     * @param \App\Models\User $user
     * @param \App\Models\Customer $customer
     * @return mixed
     */
    public function update(User $user, Customer $customer)
    {
        return (
                $user->isAdmin()
                || $user->is($customer)
                || $user->hasPermissionTo('manage.customers')
            )
            && ! $this->trashed($customer);
    }

    /**
     * Determine whether the user can update the type of the customer.
     *
     * @param \App\Models\User $user
     * @param \App\Models\Customer $customer
     * @return mixed
     */
    public function updateType(User $user, Customer $customer)
    {
        return $user->isAdmin() && $user->isNot($customer) || $user->hasPermissionTo('manage.customers');
    }

    /**
     * Determine whether the user can delete the customer.
     *
     * @param \App\Models\User $user
     * @param \App\Models\Customer $customer
     * @return mixed
     */
    public function delete(User $user, Customer $customer)
    {
        return (
                $user->isAdmin()
                && $user->isNot($customer)
                || $user->hasPermissionTo('manage.customers')
            )
            && ! $this->trashed($customer);
    }

    /**
     * Determine whether the user can view trashed customers.
     *
     * @param \App\Models\User $user
     * @return mixed
     */
    public function viewAnyTrash(User $user)
    {
        return (
                $user->isAdmin()
                || $user->hasPermissionTo('manage.customers')
            )
            && $this->hasSoftDeletes();
    }

    /**
     * Determine whether the user can view trashed customer.
     *
     * @param \App\Models\User $user
     * @param \App\Models\Customer $customer
     * @return mixed
     */
    public function viewTrash(User $user, Customer $customer)
    {
        return $this->view($user, $customer) && $this->trashed($customer);
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param \App\Models\User $user
     * @param \App\Models\Customer $customer
     * @return mixed
     */
    public function restore(User $user, Customer $customer)
    {
        return (
                $user->isAdmin()
                || $user->hasPermissionTo('manage.customers')
            )
            && $this->trashed($customer);
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param \App\Models\User $user
     * @param \App\Models\Customer $customer
     * @return mixed
     */
    public function forceDelete(User $user, Customer $customer)
    {
        return (
                $user->isAdmin()
                && $user->isNot($customer)
                || $user->hasPermissionTo('manage.customers')
            )
            && $this->trashed($customer)
            && Settings::get('delete_forever');
    }

    /**
     * Determine wither the given customer is trashed.
     *
     * @param $customer
     * @return bool
     */
    public function trashed($customer)
    {
        return $this->hasSoftDeletes() && method_exists($customer, 'trashed') && $customer->trashed();
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
            array_keys((new \ReflectionClass(Customer::class))->getTraits())
        );
    }
}
