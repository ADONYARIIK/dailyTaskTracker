<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Actions\Category\GetCategories;
use App\Actions\RecurringTask\CreateRecurringTask;
use App\Actions\RecurringTask\DeleteRecurringTask;
use App\Actions\RecurringTask\ListRecurringTasks;
use App\Actions\RecurringTask\UpdateRecurringTask;
use App\Enums\TaskFrequency;
use App\Http\Requests\StoreRecurringTaskRequest;
use App\Http\Requests\UpdateRecurringTaskRequest;
use App\Models\RecurringTask;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\View\View;

class RecurringTaskController extends Controller
{
    public function __construct(private GetCategories $getCategories) {}

    public function index(Request $request, ListRecurringTasks $listRecurringTasks): View
    {
        $recurringTasks = $listRecurringTasks->execute($request->user());

        return view(
            'recurring-tasks.index',
            [
                'recurringTasks' => $recurringTasks->toResourceCollection()->resolve(),
                'links' => fn () => $recurringTasks->links(),
                'categories' => $this->getCategories->execute($request->user()->id),
            ],
        );
    }

    public function create(Request $request): View
    {
        return view(
            'recurring-tasks.create',
            [
                'categories' => $this->getCategories->execute($request->user()->id),
                'frequency' => TaskFrequency::cases(),
            ],
        );
    }

    public function store(StoreRecurringTaskRequest $request, CreateRecurringTask $createRecurringTask): RedirectResponse
    {
        $createRecurringTask->execute($request->user(), $request->validated());

        return redirect()
            ->route('recurring-tasks.index')
            ->with('success', 'Recurring task created successfully');
    }

    public function edit(Request $request, RecurringTask $recurringTask): View
    {
        $recurringTask->load('category');

        return view(
            'recurring-tasks.edit',
            [
                'recurringTask' => $recurringTask->toResource()->resolve(),
                'categories' => $this->getCategories->execute($request->user()->id),
                'frequency' => TaskFrequency::cases(),
            ],
        );
    }

    public function update(UpdateRecurringTaskRequest $request, RecurringTask $recurringTask, UpdateRecurringTask $updateRecurringTask): RedirectResponse
    {
        $updateRecurringTask->execute($request->user(), $recurringTask, $request->validated());

        return redirect()
            ->route('recurring-tasks.index')
            ->with('success', 'Recurring task created successfully');
    }

    public function destroy(RecurringTask $recurringTask, DeleteRecurringTask $deleteRecurringTask): Response
    {
        $deleteRecurringTask->execute($recurringTask);

        return response()->noContent();
    }
}
