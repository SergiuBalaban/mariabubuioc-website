<?php

namespace App\Http\Controllers;

use App\Http\Resources\BlogResource;
use App\Http\Resources\ProjectResource;
use App\Models\Blog;
use App\Models\Project;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class UserController extends Controller
{
    public function home(Request $request): Response
    {
        $projects = Project::with('category')->orderByDesc('id')->get();
        $projectsResource = ProjectResource::collection($projects);

        return Inertia::render('Home', [
            'projects' => $projectsResource,
        ]);
    }

    public function about(Request $request): Response
    {
        return Inertia::render('About');
    }

    public function blog(Request $request): Response
    {
        $blog = Blog::query()->orderByDesc('id')->paginate(10);
        $blogsResource = BlogResource::collection($blog)->response()->getData();

        return Inertia::render('Blog', [
            'articles' => $blogsResource,
        ]);
    }

    public function article(Request $request, Blog $blog): Response
    {
        return Inertia::render('Article', [
            'article' => new BlogResource($blog),
        ]);
    }

    public function project(Request $request, Project $project): Response
    {
        return Inertia::render('Project', [
            'project' => new ProjectResource($project->load('category')),
        ]);
    }
}
