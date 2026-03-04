<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Project\CreateProjectRequest;
use App\Http\Requests\Project\UpdateProjectRequest;
use App\Http\Resources\CategoryResource;
use App\Http\Resources\ProjectResource;
use App\Models\Category;
use App\Models\Project;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class ProjectController extends Controller
{
    public function show(Request $request): Response
    {
        $projects = Project::query()->orderByDesc('id')->paginate(10);
        $projectsResource = ProjectResource::collection($projects)->response()->getData();

        return Inertia::render('Admin/Projects', [
            'projects' => $projectsResource,
        ]);
    }

    public function create(Request $request): Response
    {
        $categories = Category::all();
        $categoriesResource = CategoryResource::collection($categories)->response()->getData()->data;

        return Inertia::render('Admin/Project', [
            'categories' => $categoriesResource,
        ]);
    }

    public function store(CreateProjectRequest $request): RedirectResponse
    {
        $project = Project::create($request->validated());

        return redirect()->route('admin.projects.edit', $project);
    }

    public function edit(Request $request, Project $project): Response
    {
        $categories = Category::all();
        $categoriesResource = CategoryResource::collection($categories)->response()->getData()->data;

        return Inertia::render('Admin/Project', [
            'project' => (new ProjectResource($project))->response()->getData()->data,
            'categories' => $categoriesResource,
        ]);
    }

    public function update(UpdateProjectRequest $request, Project $project): RedirectResponse
    {
        $project->update($request->validated());

        return redirect()->route('admin.projects.edit', $project);
    }

    public function destroy(Request $request, Project $project): RedirectResponse
    {
        $project->delete();

        return redirect()->route('admin.projects');
    }
}
