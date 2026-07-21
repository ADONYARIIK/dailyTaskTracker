<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Actions\Category\CreateCategory;
use App\Actions\Category\DeleteCategory;
use App\Actions\Category\ListCategories;
use App\Actions\Category\UpdateCategory;
use App\Http\Requests\StoreCategoryRequest;
use App\Http\Requests\UpdateCategoryRequest;
use App\Models\Category;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class CategoryController extends Controller
{
    public function index(Request $request, ListCategories $listCategories): View
    {
        $categories = $listCategories->execute($request->user());

        return view(
            'categories.index',
            [
                'categories' => $categories->toResourceCollection()->resolve(),
                'links' => fn () => $categories->links(),
            ],
        );
    }

    public function create(): View
    {
        return view('categories.create');
    }

    public function store(StoreCategoryRequest $request, CreateCategory $createCategory): RedirectResponse
    {
        $createCategory->execute($request->validated(), $request->user());

        return redirect()->route('categories.index')->with(['success' => 'Category created successfully']);
    }

    public function edit(Category $category): View
    {
        return view(
            'categories.edit',
            [
                'category' => $category->toResource()->resolve(),
            ],
        );
    }

    public function update(UpdateCategoryRequest $request, Category $category, UpdateCategory $updateCategory): RedirectResponse
    {
        $updateCategory->execute($category, $request->validated());

        return redirect()
            ->route('categories.index')
            ->with(['success' => 'Category updated successfully']);
    }

    public function destroy(Category $category, DeleteCategory $deleteCategory): Response
    {
        $deleteCategory->execute($category);

        return response()->noContent();
    }
}
