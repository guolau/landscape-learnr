<?php

namespace App\Policies;

use App\Models\Tag;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class TagPolicy
{
    /**
     * Determine whether the user can create or update snippets.
     */
    public function manage(User $user): bool
    {
        return $user && $user->is_admin;
    }
}
