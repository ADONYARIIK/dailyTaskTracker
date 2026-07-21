<?php

declare(strict_types=1);

namespace App\Services;

use Illuminate\Support\Facades\Cache;

class CategoryCacheService
{
    public function getKey(int $userId): string
    {
        return 'categories.user.' . $userId;
    }

    public function remember(int $userId, \Closure $callback): array
    {
        return Cache::remember($this->getKey($userId), 3600, $callback);
    }

    public function clear(int $userId): bool
    {
        return Cache::forget($this->getKey($userId));
    }
}
