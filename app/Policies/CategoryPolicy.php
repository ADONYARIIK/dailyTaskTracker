<?php

declare(strict_types=1);

namespace App\Policies;

use App\Models\Category;
use App\Models\User;

class CategoryPolicy
{
    public function manage(User $user, Category $category): bool
    {
        return $category->user()->is($user);
    }
}
