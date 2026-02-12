<?php

use App\Http\Resources\BlogResource;
use App\Http\Resources\ProjectResource;
use App\Models\Blog;
use App\Models\Project;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/', function () {
    return Inertia::render('Home', [
        'projects' => ProjectResource::collection(Project::with('category')->orderByDesc('id')->get()),
    ]);
})->name('home');

Route::get('/about', function () {
    return Inertia::render('About');
})->name('about');

Route::get('/blog', function () {
    return Inertia::render('Blog', [
        'articles' => BlogResource::collection(Blog::query()->orderByDesc('id')->paginate(10))->response()->getData(),
    ]);
})->name('blog');

Route::get('/blogs/{blog}', function (Blog $blog) {
    return Inertia::render('Article', [
        'article' => new BlogResource($blog),
    ]);
})->name('blog.article');

Route::get('/projects/{project}', function (Project $project) {
    return Inertia::render('Project', [
        'project' => new ProjectResource($project->load('category')),
    ]);
})->name('project.detail');

Route::get('dashboard', function () {
    return Inertia::render('Dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::get('/admin/blogs', function () {
    return Inertia::render('Admin/Blogs', [
        'blogs' => BlogResource::collection(Blog::query()->orderByDesc('id')->paginate(10))->response()->getData(),
    ]);
})->middleware('auth')->name('admin.blogs');

Route::get('/admin/blogs/{blog}', function (Blog $blog) {
    return Inertia::render('Admin/Article', [
        'blog' => (new BlogResource($blog))->response()->getData()->data,
    ]);
})->middleware('auth')->name('admin.blogs.edit');

Route::put('/admin/blogs/{blog}', function (Blog $blog) {
    $blog->update(request()->validate([
        'cover' => 'nullable|string',
        'title' => 'required|string|max:255',
        'author' => 'nullable|string|max:255',
        'content' => 'nullable|array',
        'details' => 'nullable|array',
    ]));

    return redirect()->route('admin.blogs.edit', $blog);
})->middleware('auth')->name('admin.blogs.update');

Route::delete('/admin/blogs/{blog}', function (Blog $blog) {
    $blog->delete();

    return redirect()->route('admin.blogs');
})->middleware('auth')->name('admin.blogs.destroy');

require __DIR__.'/settings.php';
