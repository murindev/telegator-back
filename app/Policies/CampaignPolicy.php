<?php

namespace App\Policies;

use App\Models\Campaign;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class CampaignPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any models.
     *
     * @param User $user
     *
     * @return mixed
     */
    public function viewAny(User $user): bool
    {
//        return true;
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param User     $user
     * @param Campaign $campaign
     *
     * @return mixed
     */
    public function view(User $user, Campaign $campaign): bool
    {
        return $user->id === $campaign->user_id;
    }

    /**
     * Determine whether the user can create models.
     *
     * @param User  $user
     *
     * @return mixed
     */
    public function create(User $user): bool
    {
        return true;
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param User     $user
     * @param Campaign $campaign
     *
     * @return mixed
     */
    public function update(User $user, Campaign $campaign): bool
    {
        return $user->id === $campaign->user_id;
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param User     $user
     * @param Campaign $campaign
     *
     * @return mixed
     */
    public function delete(User $user, Campaign $campaign): bool
    {
        return $user->id === $campaign->user_id;
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param User     $user
     * @param Campaign $campaign
     *
     * @return mixed
     */
    public function restore(User $user, Campaign $campaign): bool
    {
        return $user->id === $campaign->user_id;
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param User     $user
     * @param Campaign $campaign
     *
     * @return mixed
     */
    public function forceDelete(User $user, Campaign $campaign): bool
    {
        return false;
    }
}
