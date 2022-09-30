<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Delegate;
use Illuminate\Database\Eloquent\SoftDeletes;
use Laraeast\LaravelSettings\Facades\Settings;
use Illuminate\Auth\Access\HandlesAuthorization;

class DelegatePolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any delegates.
     *
     * @param \App\Models\User $user
     * @return mixed
     */
    public function viewAny(User $user)
    {
        return $user->isAdmin() || $user->hasPermissionTo('manage.delegates');
    }

    /**
     * Determine whether the user can view the delegate.
     *
     * @param \App\Models\User $user
     * @param \App\Models\Delegate $delegate
     * @return mixed
     */
    public function view(User $user, Delegate $delegate)
    {
        return $user->isAdmin() || $user->is($delegate) || $user->hasPermissionTo('manage.delegates');
    }

    /**
     * Determine whether the user can create delegates.
     *
     * @param \App\Models\User $user
     * @return mixed
     */
    public function create(User $user)
    {
        return $user->isAdmin() || $user->hasPermissionTo('manage.delegates');
    }

    /**
     * Determine whether the user can update the delegate.
     *
     * @param \App\Models\User $user
     * @param \App\Models\Delegate $delegate
     * @return mixed
     */
    public function update(User $user, Delegate $delegate)
    {
        return ($user->isAdmin() || $user->is($delegate) || $user->hasPermissionTo('manage.delegates')) && ! $this->trashed($delegate);
    }

    /**
     * Determine whether the user can update the type of the delegate.
     *
     * @param \App\Models\User $user
     * @param \App\Models\Delegate $delegate
     * @return mixed
     */
    public function updateType(User $user, Delegate $delegate)
    {
        return $user->isAdmin() && $user->isNot($delegate) || $user->hasPermissionTo('manage.delegates');
    }

    /**
     * Determine whether the user can delete the delegate.
     *
     * @param \App\Models\User $user
     * @param \App\Models\Delegate $delegate
     * @return mixed
     */
    public function delete(User $user, Delegate $delegate)
    {
        return ($user->isAdmin() && $user->isNot($delegate) || $user->hasPermissionTo('manage.delegates')) && ! $this->trashed($delegate);
    }

    /**
     * Determine whether the user can view trashed delegates.
     *
     * @param \App\Models\User $user
     * @return mixed
     */
    public function viewAnyTrash(User $user)
    {
        return ($user->isAdmin() || $user->hasPermissionTo('manage.delegates')) && $this->hasSoftDeletes();
    }

    /**
     * Determine whether the user can view trashed delegate.
     *
     * @param \App\Models\User $user
     * @param \App\Models\Delegate $delegate
     * @return mixed
     */
    public function viewTrash(User $user, Delegate $delegate)
    {
        return $this->view($user, $delegate) && $this->trashed($delegate);
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param \App\Models\User $user
     * @param \App\Models\Delegate $delegate
     * @return mixed
     */
    public function restore(User $user, Delegate $delegate)
    {
        return ($user->isAdmin() || $user->hasPermissionTo('manage.delegates')) && $this->trashed($delegate);
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param \App\Models\User $user
     * @param \App\Models\Delegate $delegate
     * @return mixed
     */
    public function forceDelete(User $user, Delegate $delegate)
    {
        return (
                $user->isAdmin()
                && $user->isNot($delegate)
                || $user->hasPermissionTo('manage.delegates')
            )
            && $this->trashed($delegate)
            && Settings::get('delete_forever');
    }

    /**
     * Determine wither the given delegate is trashed.
     *
     * @param $delegate
     * @return bool
     */
    public function trashed($delegate)
    {
        return $this->hasSoftDeletes() && method_exists($delegate, 'trashed') && $delegate->trashed();
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
            array_keys((new \ReflectionClass(Delegate::class))->getTraits())
        );
    }
}
