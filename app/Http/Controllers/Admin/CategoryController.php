<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Resources\CategoryResource;
use App\Models\Category;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class CategoryController extends Controller
{
    public function index(Request $request): Response
    {
        $categories = Category::query()->orderByDesc('id')->paginate(10);
        $categoriesResource = CategoryResource::collection($categories)->response()->getData();

        return Inertia::render('Admin/Categories', [
            'categories' => $categoriesResource,
        ]);
    }

    public function create(Request $request): Response
    {
        return Inertia::render('Admin/Category');
    }

    public function store(Request $request): RedirectResponse
    {
        $category = Category::create($request->validate([
            'name' => 'required|string|max:255',
        ]));

        return redirect()->route('admin.categories.edit', $category);
    }

    public function edit(Request $request, Category $category): Response
    {
        return Inertia::render('Admin/Category', [
            'category' => (new CategoryResource($category))->response()->getData()->data,
        ]);
    }

    public function update(Request $request, Category $category): RedirectResponse
    {
        $category->update($request->validate([
            'name' => 'required|string|max:255',
        ]));

        return redirect()->route('admin.categories.edit', $category);
    }

    public function destroy(Request $request, Category $category): RedirectResponse
    {
        $category->delete();

        return redirect()->route('admin.categories');
    }
}
