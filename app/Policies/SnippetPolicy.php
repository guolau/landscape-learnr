<?php

namespace App\Policies;

use App\Models\Snippet;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class SnippetPolicy
{
    /**
     * Determine whether the user can create or update snippets.
     */
    public function manage(User $user): bool
    {
        return $user && $user->is_admin;
    }
}
