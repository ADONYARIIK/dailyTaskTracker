<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreCategoryRequest;
use App\Http\Requests\UpdateCategoryRequest;
use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function index(Request $request)
    {
        $user = $request->user();

        $categories = $user->categories()->latest()->paginate();

        return view('categories.index', [
            'categories' => $categories->toResourceCollection()->resolve(),
            'links' => fn () => $categories->links(),
        ]);
    }

    public function create()
    {
        return view('categories.create');
    }

    public function store(StoreCategoryRequest $request)
    {
        $request->user()->categories()->create($request->validated());

        return redirect()->route('categories.index')->with(['success' => 'Category created successfully']);
    }

    public function edit(Category $category)
    {
        return view('categories.edit', ['category' => $category->toResource()->resolve()]);
    }

    public function update(UpdateCategoryRequest $request, Category $category)
    {
        $category->update($request->validated());

        return redirect()->route('categories.index')->with(['success' => 'Category updated successfully']);
    }

    public function destroy(Category $category)
    {
        $category->delete();

        return redirect()->route('categories.index')->with(['success' => 'Category deleted successfully']);
    }
}
