<?php

namespace App\Http\Controllers;

use App\Enums\TaskFrequency;
use App\Http\Requests\StoreRecurringTaskRequest;
use App\Http\Requests\UpdateRecurringTaskRequest;
use App\Models\Category;
use App\Models\RecurringTask;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;

class RecurringTaskController extends Controller
{
    public function index(Request $request): View
    {
        $recurringTasks = $request->user()
            ->recurringTasks()
            ->with('category')
            ->latest()
            ->paginate();

        return view('recurring-tasks.index', [
            'recurringTasks' => $recurringTasks->toResourceCollection()->resolve(),
            'links' => fn() => $recurringTasks->links(),
        ]);
    }

    public function create(Request $request): View
    {
        $categories = $request->user()->categories()->orderBy('name')->pluck('name', 'uuid')->toArray();

        return view('recurring-tasks.create', ['categories' => $categories]);
    }

    public function store(StoreRecurringTaskRequest $request): RedirectResponse
    {
        $data = $request->validated();

        if ($request->category_id) {
            $category = Category::where('uuid', $request->category_id)->first();

            if (!$category || $request->user()->cannot('manage', $category)) {
                throw ValidationException::withMessages(['category_id' => 'The given category id does not exists.']);
            }

            $data['category_id'] = $category->id;
        }

        $data['frequency_config'] = $this->buildFrequencyConfig($data);

        unset($data['days'], $data['day_of_month']);

        $request->user()->recurringTasks()->create($data);

        return redirect()->route('recurring-tasks.index')->with('success', 'Recurring task created successfully');
    }

    public function edit(Request $request, RecurringTask $recurringTask): View
    {
        $recurringTask->load('category');

        $categories = $request->user()->categories()->orderBy('name')->pluck('name', 'uuid')->toArray();

        return view('recurring-tasks.edit', [
            'recurringTask' => $recurringTask->toResource()->resolve(),
            'categories' => $categories,
        ]);
    }

    public function update(UpdateRecurringTaskRequest $request, RecurringTask $recurringTask): RedirectResponse
    {
        $data = $request->validated();

        if ($request->category_id) {
            $category = Category::where('uuid', $request->category_id)->first();

            if (!$category || $request->user()->cannot('manage', $category)) {
                throw ValidationException::withMessages(['category_id' => 'The given category id does not exists.']);
            }

            $recurringTask->category()->associate($category);

            unset($data['category_id']);
        }

        $data['frequency_config'] = $this->buildFrequencyConfig($data);

        unset($data['days'], $data['day_of_month']);

        $recurringTask->fill($data);
        $recurringTask->save();

        return redirect()->route('recurring-tasks.index')->with('success', 'Recurring task created successfully');
    }

    public function destroy(RecurringTask $recurringTask): RedirectResponse
    {
        $recurringTask->delete();

        return redirect()->route('recurring-tasks.index')->with('success', 'Recurring task deleted successfully');
    }

    private function buildFrequencyConfig(array $data): ?array
    {
        $frequency = $data['frequency'];

        if ($frequency === TaskFrequency::Weekly->value && isset($data['days'])) {
            return ['days' => $data['days']];
        }

        if ($frequency === TaskFrequency::Monthly->value && isset($data['day_of_month'])) {
            return ['day_of_month' => (int) $data['day_of_month']];
        }

        return null;
    }
}
