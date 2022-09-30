<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Report;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Auth\Access\HandlesAuthorization;

class ReportPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any reports.
     *
     * @param \App\Models\User|null $user
     * @return mixed
     */
    public function viewAny(User $user)
    {
        return $user->isAdmin() || $user->hasPermissionTo('manage.reports');
    }

    /**
     * Determine whether the user can view the report.
     *
     * @param \App\Models\User|null $user
     * @param \App\Models\Report $report
     * @return mixed
     */
    public function view(User $user, Report $report)
    {
        return $user->isAdmin() || $user->hasPermissionTo('manage.reports');
    }

    /**
     * Determine whether the user can create reports.
     *
     * @param \App\Models\User $user
     * @return mixed
     */
    public function create(User $user)
    {
        return $user->isAdmin() || $user->hasPermissionTo('manage.reports');
    }

    /**
     * Determine whether the user can update the report.
     *
     * @param \App\Models\User $user
     * @param \App\Models\Report $report
     * @return mixed
     */
    public function update(User $user, Report $report)
    {
        return ($user->isAdmin() || $user->hasPermissionTo('manage.reports')) && ! $this->trashed($report);
    }

    /**
     * Determine whether the user can delete the report.
     *
     * @param \App\Models\User $user
     * @param \App\Models\Report $report
     * @return mixed
     */
    public function delete(User $user, Report $report)
    {
        return ($user->isAdmin() || $user->hasPermissionTo('manage.reports')) && ! $this->trashed($report);
    }

    /**
     * Determine whether the user can view trashed reports.
     *
     * @param \App\Models\User $user
     * @return mixed
     */
    public function viewAnyTrash(User $user)
    {
        return ($user->isAdmin() || $user->hasPermissionTo('manage.reports')) && $this->hasSoftDeletes();
    }

    /**
     * Determine whether the user can view the trashed report.
     *
     * @param \App\Models\User|null $user
     * @param \App\Models\Report $report
     * @return mixed
     */
    public function viewTrash(User $user, Report $report)
    {
        return $this->view($user, $report) && $report->trashed();
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param \App\Models\User $user
     * @param \App\Models\Report $report
     * @return mixed
     */
    public function restore(User $user, Report $report)
    {
        return ($user->isAdmin() || $user->hasPermissionTo('manage.reports')) && $this->trashed($report);
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param \App\Models\User $user
     * @param \App\Models\Report $report
     * @return mixed
     */
    public function forceDelete(User $user, Report $report)
    {
        return ($user->isAdmin() && $user->isNot($report) || $user->hasPermissionTo('manage.reports')) && $this->trashed($report);
    }

    /**
     * Determine wither the given report is trashed.
     *
     * @param $report
     * @return bool
     */
    public function trashed($report)
    {
        return $this->hasSoftDeletes() && method_exists($report, 'trashed') && $report->trashed();
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
            array_keys((new \ReflectionClass(Report::class))->getTraits())
        );
    }
}
