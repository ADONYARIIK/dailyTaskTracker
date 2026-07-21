<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Actions\Category\GetCategories;
use App\Actions\Task\CreateTask;
use App\Actions\Task\DeleteTask;
use App\Actions\Task\ListTasks;
use App\Actions\Task\ToggleTaskCompletion;
use App\Actions\Task\UpdateTask;
use App\Http\Requests\FilterTasksRequest;
use App\Http\Requests\StoreTaskRequest;
use App\Http\Requests\UpdateTaskRequest;
use App\Models\Task;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\View\View;

class TaskController extends Controller
{
    public function __construct(private GetCategories $getCategories) {}

    public function index(FilterTasksRequest $request, ListTasks $listTasks): View
    {
        $user = $request->user();
        $filters = $request->only(['status', 'category_id', 'from', 'to']);

        $tasks = $listTasks->execute($user, $filters);

        return view(
            'tasks.index',
            [
                'tasks' => $tasks->toResourceCollection()->resolve(),
                'links' => fn () => $tasks->links(),
                'categories' => $this->getCategories->execute($user->id),
                'filters' => $filters,
            ],
        );
    }

    public function create(Request $request): View
    {
        return view(
            'tasks.create',
            [
                'categories' => $this->getCategories->execute($request->user()->id),
            ],
        );
    }

    public function store(StoreTaskRequest $request, CreateTask $createTask): RedirectResponse
    {
        $createTask->execute($request->validated(), $request->user());

        return redirect()
            ->route('tasks.index')
            ->with('success', 'Task created successfully');
    }

    public function edit(Request $request, Task $task): View
    {
        $task->load('category');

        return view('tasks.edit', [
            'task' => $task->toResource()->resolve(),
            'categories' => $this->getCategories->execute($request->user()->id),
        ]);
    }

    public function update(UpdateTaskRequest $request, Task $task, UpdateTask $updateTask): RedirectResponse
    {
        $updateTask->execute($request->user(), $task, $request->validated());

        return redirect()
            ->route('tasks.index')
            ->with('success', 'Task updated successfully');
    }

    public function destroy(Task $task, DeleteTask $deleteTask): Response
    {
        $deleteTask->execute($task);

        return response()->noContent();
    }

    public function toggleCompletion(Task $task, ToggleTaskCompletion $toggleTaskCompletion): JsonResponse
    {
        $completed = $toggleTaskCompletion->execute($task);

        return response()->json(
            [
                'completed' => $task->completed_at !== null,
            ],
        );
    }
}
