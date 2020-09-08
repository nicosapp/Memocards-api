<?php

namespace App\Policies;

use App\Post;
use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class PostPolicy
{
    use HandlesAuthorization;

    public function show(?User $user, Post $post)
    {
        return optional($user)->id === $post->user_id;
    }

    public function update(User $user, Post $post)
    {
        return $user->id === $post->user_id;
    }

    public function destroy(User $user, Post $post)
    {
        return $user->id === $post->user_id;
    }
}