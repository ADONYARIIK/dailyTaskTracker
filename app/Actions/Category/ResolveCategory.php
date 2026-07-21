<?php

declare(strict_types=1);

namespace App\Actions\Category;

use App\Models\Category;
use App\Models\User;
use Illuminate\Validation\ValidationException;

class ResolveCategory
{
    /**
     * Create a new class instance.
     */
    public function __construct()
    {
        //
    }

    public function execute(User $user, ?string $categoryUuid): ?int
    {
        if (! $categoryUuid) {
            return null;
        }

        $category = Category::where('uuid', $categoryUuid)->first();

        if (! $category || $user->cannot('manage', $category)) {
            throw ValidationException::withMessages(['category_id' => 'The given category id does not exists.']);
        }

        return $category->id;
    }
}
