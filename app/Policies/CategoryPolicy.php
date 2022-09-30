<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Category;
use Illuminate\Database\Eloquent\SoftDeletes;
use Laraeast\LaravelSettings\Facades\Settings;
use Illuminate\Auth\Access\HandlesAuthorization;

class CategoryPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any categories.
     *
     * @param \App\Models\User|null $user
     * @return mixed
     */
    public function viewAny(User $user)
    {
        return $user->isAdmin() || $user->hasPermissionTo('manage.categories');
    }

    /**
     * Determine whether the user can view the category.
     *
     * @param \App\Models\User|null $user
     * @param \App\Models\Category $category
     * @return mixed
     */
    public function view(User $user, Category $category)
    {
        return $user->isAdmin() || $user->hasPermissionTo('manage.categories');
    }

    /**
     * Determine whether the user can create categories.
     *
     * @param \App\Models\User $user
     * @return mixed
     */
    public function create(User $user)
    {
        return $user->isAdmin() || $user->hasPermissionTo('manage.categories');
    }

    /**
     * Determine whether the user can update the category.
     *
     * @param \App\Models\User $user
     * @param \App\Models\Category $category
     * @return mixed
     */
    public function update(User $user, Category $category)
    {
        return ($user->isAdmin() || $user->hasPermissionTo('manage.categories')) && ! $this->trashed($category);
    }

    /**
     * Determine whether the user can delete the category.
     *
     * @param \App\Models\User $user
     * @param \App\Models\Category $category
     * @return mixed
     */
    public function delete(User $user, Category $category)
    {
        return ($user->isAdmin() || $user->hasPermissionTo('manage.categories')) && ! $this->trashed($category);
    }

    /**
     * Determine whether the user can view trashed categories.
     *
     * @param \App\Models\User $user
     * @return mixed
     */
    public function viewAnyTrash(User $user)
    {
        return ($user->isAdmin() || $user->hasPermissionTo('manage.categories')) && $this->hasSoftDeletes();
    }

    /**
     * Determine whether the user can view the trashed category.
     *
     * @param \App\Models\User|null $user
     * @param \App\Models\Category $category
     * @return mixed
     */
    public function viewTrash(User $user, Category $category)
    {
        return $this->view($user, $category) && $category->trashed();
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param \App\Models\User $user
     * @param \App\Models\Category $category
     * @return mixed
     */
    public function restore(User $user, Category $category)
    {
        return ($user->isAdmin() || $user->hasPermissionTo('manage.categories')) && $this->trashed($category);
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param \App\Models\User $user
     * @param \App\Models\Category $category
     * @return mixed
     */
    public function forceDelete(User $user, Category $category)
    {
        return (
                $user->isAdmin()
                || $user->hasPermissionTo('manage.categories')
            )
            && $this->trashed($category)
            && Settings::get('delete_forever');
    }

    /**
     * Determine wither the given category is trashed.
     *
     * @param $category
     * @return bool
     */
    public function trashed($category)
    {
        return $this->hasSoftDeletes() && method_exists($category, 'trashed') && $category->trashed();
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
            array_keys((new \ReflectionClass(Category::class))->getTraits())
        );
    }
}
