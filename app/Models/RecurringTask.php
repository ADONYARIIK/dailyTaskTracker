<?php

namespace App\Models;

use App\Enums\TaskFrequency;
use Illuminate\Console\Attributes\Hidden;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Carbon;

/**
 * @property int $id
 * @property string $uuid
 * @property int $user_id
 * @property int|null $category_id
 * @property string $title
 * @property string|null $description
 * @property TaskFrequency $frequency
 * @property array<array-key, mixed>|null $frequency_config
 * @property Carbon|null $start_date
 * @property Carbon|null $end_date
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property Carbon|null $deleted_at
 * @property-read \App\Models\Category|null $category
 * @property-read Collection<int, \App\Models\Task> $tasks
 * @property-read int|null $tasks_count
 * @property-read \App\Models\User $user
 * @method static \Database\Factories\RecurringTaskFactory factory($count = null, $state = [])
 * @method static Builder<static>|RecurringTask newModelQuery()
 * @method static Builder<static>|RecurringTask newQuery()
 * @method static Builder<static>|RecurringTask onlyTrashed()
 * @method static Builder<static>|RecurringTask query()
 * @method static Builder<static>|RecurringTask whereCategoryId($value)
 * @method static Builder<static>|RecurringTask whereCreatedAt($value)
 * @method static Builder<static>|RecurringTask whereDeletedAt($value)
 * @method static Builder<static>|RecurringTask whereDescription($value)
 * @method static Builder<static>|RecurringTask whereEndDate($value)
 * @method static Builder<static>|RecurringTask whereFrequency($value)
 * @method static Builder<static>|RecurringTask whereFrequencyConfig($value)
 * @method static Builder<static>|RecurringTask whereId($value)
 * @method static Builder<static>|RecurringTask whereStartDate($value)
 * @method static Builder<static>|RecurringTask whereTitle($value)
 * @method static Builder<static>|RecurringTask whereUpdatedAt($value)
 * @method static Builder<static>|RecurringTask whereUserId($value)
 * @method static Builder<static>|RecurringTask whereUuid($value)
 * @method static Builder<static>|RecurringTask withTrashed(bool $withTrashed = true)
 * @method static Builder<static>|RecurringTask withoutTrashed()
 * @mixin \Eloquent
 */
#[Fillable(['user_id', 'category_id', 'title', 'description', 'frequency', 'frequency_config', 'start_date', 'end_date'])]
#[Hidden(['id'])]
class RecurringTask extends Model
{
    use HasUuids, SoftDeletes, HasFactory;

    protected function casts(): array
    {
        return [
            'frequency' => TaskFrequency::class,
            'frequency_config' => 'array',
            'start_date' => 'date',
            'end_date' => 'date',
        ];
    }

    public function getRouteKeyName(): string
    {
        return 'uuid';
    }

    /**
     * @return list<string>
     */
    public function uniqueIds(): array
    {
        return ['uuid'];
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function tasks(): HasMany
    {
        return $this->hasMany(Task::class);
    }
}
