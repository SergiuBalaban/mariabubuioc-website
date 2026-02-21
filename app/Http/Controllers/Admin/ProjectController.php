<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Resources\ProjectResource;
use App\Models\Project;
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
}
