<?php

namespace App\Policies;

use App\Models\Profile;
use App\Models\User;

class ProfilePolicy
{
    /**
     * Determine whether the user can view the profile.
     */
    public function view(User $user, Profile $profile): bool
    {
        return $this->owns($user, $profile);
    }

    /**
     * Determine whether the user can update the profile.
     */
    public function update(User $user, Profile $profile): bool
    {
        return $this->owns($user, $profile);
    }

    /**
     * A profile belongs to exactly one user, so the foreign key alone settles
     * ownership without loading a relation.
     */
    private function owns(User $user, Profile $profile): bool
    {
        return $profile->user_id === $user->id;
    }
}
