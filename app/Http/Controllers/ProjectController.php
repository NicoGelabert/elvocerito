<?php

namespace App\Http\Controllers;

use App\Models\Service;
use App\Models\Project;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;

class ProjectController extends Controller
{
    public function index()
    {
        $query = Project::query();

        return $this->renderProjects($query);
    }

    public function byCategory(Service $service)
    {
        $services = Service::getAllChildrenByParent($service);

        $query = Project::query()
            ->select('projects.*')
            ->join('project_services AS ps', 'ps.project_id', 'projects.id')
            ->whereIn('ps.service_id', array_map(fn($c) => $c->id, $services));

        return $this->renderProjects($query);
    }

    public function view(Project $project)
    {
        return view('project.view', ['project' => $project]);
    }

    private function renderProjects(Builder $query)
    {
        $search = \request()->get('search');
        $sort = \request()->get('sort', '-updated_at');

        if ($sort) {
            $sortDirection = 'asc';
            if ($sort[0] === '-') {
                $sortDirection = 'desc';
            }
            $sortField = preg_replace('/^-?/', '', $sort);

            $query->orderBy($sortField, $sortDirection);
        }
        $projects = $query
            ->where('published', '=', 1)
            ->where(function ($query) use ($search) {
                /** @var $query \Illuminate\Database\Eloquent\Builder */
                $query->where('projects.title', 'like', "%$search%")
                    ->orWhere('projects.description', 'like', "%$search%");
            })

            ->paginate(5);

        return view('project.index', [
            'projects' => $projects
        ]);

    }
}
