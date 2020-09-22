<?php

namespace App\Policies;

use App\Models\Tag;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class TagPolicy
{
    use HandlesAuthorization;

    public function update(User $user, Tag $tag)
    {
        return $user->id === $tag->user_id;
    }

    public function destroy(User $user, Tag $tag)
    {
        return $user->id === $tag->user_id;
    }
}
