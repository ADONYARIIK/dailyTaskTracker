<?php

namespace App\Http\Controllers;

use App\Http\Requests\FilterTasksRequest;
use App\Http\Requests\StoreTaskRequest;
use App\Http\Requests\UpdateTaskRequest;
use App\Models\Category;
use App\Models\Task;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;

class TaskController extends Controller
{
    public function index(FilterTasksRequest $request): View
    {
        $user = $request->user();

        if ($request->category_id) {
            $category = Category::where('uuid', $request->category_id)->first();

            if (! $category || $request->user()->cannot('manage', $category)) {
                throw ValidationException::withMessages(['category_id' => 'The given category id does not exists.']);
            }
        }

        $tasks = $user->tasks()->with('category')
            ->when($request->status === 'completed', fn ($query) => $query->whereNotNull('completed_at'))
            ->when($request->status === 'incomplete', fn ($query) => $query->whereNull('completed_at'))
            ->when($request->filled('category_id'), fn ($query) => $query->where('category_id', $request->category_id))
            ->when($request->filled('from'), fn ($query) => $query->whereDate('task_date', '>=', $request->from))
            ->when($request->filled('to'), fn ($query) => $query->whereDate('task_date', '<=', $request->to))
            ->latest()
            ->paginate();

        $categories = $request->user()->categories()->orderBy('name')->pluck('name', 'uuid')->toArray();

        return view('tasks.index', [
            'tasks' => $tasks->toResourceCollection()->resolve(),
            'links' => fn () => $tasks->links(),
            'categories' => $categories,
            'filters' => $request->only(['status', 'category_id', 'from', 'to']),
        ]);
    }

    public function create(Request $request): View
    {
        $categories = $request->user()->categories()->orderBy('name')->pluck('name', 'uuid')->toArray();

        return view('tasks.create', ['categories' => $categories]);
    }

    public function store(StoreTaskRequest $request): RedirectResponse
    {
        $taskData = $request->validated();

        if ($request->category_id) {
            $category = Category::where('uuid', $request->category_id)->first();

            if (! $category || $request->user()->cannot('manage', $category)) {
                throw ValidationException::withMessages(['category_id' => 'The given category id does not exists.']);
            }

            $taskData['category_id'] = $category->id;
        }

        $request->user()->tasks()->create($taskData);

        return redirect()->route('tasks.index')->with('success', 'Task created successfully');
    }

    public function edit(Request $request, Task $task): View
    {
        $task->load('category');

        $categories = $request->user()->categories()->orderBy('name')->pluck('name', 'uuid')->toArray();

        return view('tasks.edit', [
            'task' => $task->toResource()->resolve(),
            'categories' => $categories,
        ]);
    }

    public function update(UpdateTaskRequest $request, Task $task): RedirectResponse
    {
        $validData = $request->validated();

        if ($request->category_id) {
            $category = Category::where('uuid', $request->category_id)->first();

            if (! $category || $request->user()->cannot('manage', $category)) {
                throw ValidationException::withMessages(['category_id' => 'The given category id does not exists.']);
            }

            $task->category()->associate($category);

            unset($validData['category_id']);
        }

        $task->fill($validData);
        $task->save();

        return redirect()->route('tasks.index')->with('success', 'Task updated successfully');
    }

    public function destroy(Task $task): RedirectResponse
    {
        $task->delete();

        return redirect()->route('tasks.index')->with('success', 'Task deleted successfully');
    }

    public function toggleCompletion(Task $task): RedirectResponse
    {
        $task->update(['completed_at' => $task->completed_at ? null : now()]);

        return back()->with('success', $task->completed_at ? 'Task completed successfully' : 'Task marked incomplete successfully');
    }
}
