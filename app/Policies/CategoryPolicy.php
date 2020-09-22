<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Category;
use Illuminate\Auth\Access\HandlesAuthorization;

class CategoryPolicy
{
    use HandlesAuthorization;

    public function update(User $user, Category $category)
    {
        return $user->id === $category->user_id;
    }

    public function destroy(User $user, Category $category)
    {
        return $user->id === $category->user_id;
    }
}
