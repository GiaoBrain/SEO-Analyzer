<?php

namespace App\Policies;

use App\Models\Report;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class ReportPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any reports.
     *
     * @param  \App\Models\User  $user
     * @return mixed
     */
    public function viewAny(User $user)
    {
        //
    }

    /**
     * Determine whether the user can view the report.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Report  $report
     * @return mixed
     */
    public function view(User $user, Report $report)
    {
        //
    }

    /**
     * Determine whether the user can create reports.
     *
     * @param  \App\Models\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        if ($user->plan->features->reports == -1) {
            return true;
        } elseif($user->plan->features->reports > 0) {
            if ($user->reportsCount < $user->plan->features->reports) {
                return true;
            }
        }

        return false;
    }

    /**
     * Determine whether the user can update the report.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Report  $report
     * @return mixed
     */
    public function update(User $user, Report $report)
    {
        //
    }

    /**
     * Determine whether the user can delete the report.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Report  $report
     * @return mixed
     */
    public function delete(User $user, Report $report)
    {
        //
    }

    /**
     * Determine whether the user can restore the report.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Report  $report
     * @return mixed
     */
    public function restore(User $user, Report $report)
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the report.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Report  $report
     * @return mixed
     */
    public function forceDelete(User $user, Report $report)
    {
        //
    }
}
