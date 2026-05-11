<?php

namespace App\Http\Controllers\Web\Category;

use App\Http\Controllers\Controller;
use App\Http\Requests\Category\StoreCategoryRequest;
use App\Http\Requests\Category\UpdateCategoryRequest;
use App\Services\Category\CategoryService;
use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;

class CategoryController extends Controller implements HasMiddleware
{
    protected $categoryService;

    public static function middleware(): array
    {
        return [
            new Middleware('permission:view_product_categories', only: ['index']),
            new Middleware('permission:create_product_categories', only: ['create', 'store']),
            new Middleware('permission:update_product_categories', only: ['edit', 'update']),
            new Middleware('permission:delete_product_categories', only: ['destroy']),
        ];
    }

    public function __construct(CategoryService $categoryService)
    {
        $this->categoryService = $categoryService;
    }

    public function index()
    {
        $categories = $this->categoryService->getAll();

        return view('categories.index', compact('categories'));
    }

    public function create()
    {
        return view('categories.create');
    }

    public function store(StoreCategoryRequest $request)
    {
        $this->categoryService->store($request);

        return redirect()
            ->route('categories.index')
            ->with('success', 'Category Created Successfully');
    }

    public function edit($id)
    {
        $category = $this->categoryService->findById($id);

        return view('categories.edit', compact('category'));
    }

    public function update(UpdateCategoryRequest $request, $id)
    {
        $this->categoryService->update($request, $id);

        return redirect()
            ->route('categories.index')
            ->with('success', 'Category Updated Successfully');
    }

    public function destroy($id)
    {
        $this->categoryService->delete($id);

        return redirect()
            ->route('categories.index')
            ->with('success', 'Category Deleted Successfully');
    }
}
