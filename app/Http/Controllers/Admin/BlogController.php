<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Resources\BlogResource;
use App\Models\Blog;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class BlogController extends Controller
{
    public function show(Request $request): Response
    {
        $blogs = Blog::query()->orderByDesc('id')->paginate(10);
        $blogsResource = BlogResource::collection($blogs)->response()->getData();

        return Inertia::render('Admin/Blogs', [
            'blogs' => $blogsResource,
        ]);
    }

    public function edit(Request $request, Blog $blog): Response
    {
        return Inertia::render('Admin/Article', [
            'blog' => (new BlogResource($blog))->response()->getData()->data,
        ]);
    }

    public function update(Request $request, Blog $blog): RedirectResponse
    {
        $blog->update(request()->validate([
            'cover' => 'nullable|string',
            'title' => 'required|string|max:255',
            'author' => 'nullable|string|max:255',
            'content' => 'nullable|array',
            'details' => 'nullable|array',
        ]));

        return redirect()->route('admin.blogs.edit', $blog);
    }

    public function destroy(Request $request, Blog $blog): RedirectResponse
    {
        $blog->delete();

        return redirect()->route('admin.blogs');
    }
}
