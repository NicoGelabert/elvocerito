<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\ProjectRequest;
use App\Http\Resources\ProjectListResource;
use App\Http\Resources\ProjectResource;
use App\Models\Api\Project;
use App\Models\ProjectService;
use App\Models\ProjectImage;
use App\Models\ProjectClient;
use App\Models\ProjectTag;
use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Str;

class ProjectController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $perPage = request('per_page', 10);
        $search = request('search', '');
        $sortField = request('sort_field', 'created_at');
        $sortDirection = request('sort_direction', 'desc');

        $query = Project::query()
            ->where('title', 'like', "%{$search}%")
            ->orderBy($sortField, $sortDirection)
            ->paginate($perPage);

        return ProjectListResource::collection($query);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(ProjectRequest $request)
    {
        $data = $request->validated();
        $data['created_by'] = $request->user()->id;
        $data['updated_by'] = $request->user()->id;

        /** @var \Illuminate\Http\UploadedFile[] $images */
        $images = $data['images'] ?? [];
        $imagePositions = $data['image_positions'] ?? [];
        $services = $data['services'] ?? [];
        $clients = $data['clients'] ?? [];
        $tags = $data['tags'] ?? [];

        $project = Project::create($data);

        $this->saveServices($services, $project);
        $this->saveImages($images, $imagePositions, $project);
        $this->saveClients($clients, $project);
        $this->saveTags($tags, $project);

        return new ProjectResource($project);
    }

    /**
     * Display the specified resource.
     *
     * @param \App\Models\Project $project
     * @return \Illuminate\Http\Response
     */
    public function show(Project $project)
    {
        return new ProjectResource($project);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Product      $product
     * @return \Illuminate\Http\Response
     */
    public function update(ProjectRequest $request, Project $project)
    {
        $data = $request->validated();
        $data['updated_by'] = $request->user()->id;
        $services = $data['services'] ?? [];
        $clients = $data['clients'] ?? [];
        $tags = $data['tags'] ?? [];
        $prices = $data['prices'] ?? [];
        
        /** @var \Illuminate\Http\UploadedFile[] $images */
        $images = $data['images'] ?? [];
        $deletedImages = $data['deleted_images'] ?? [];
        $imagePositions = $data['image_positions'] ?? [];

        $this->saveServices($services, $project);
        $this->saveImages($images, $imagePositions, $project);
        if (count($deletedImages) > 0) {
            $this->deleteImages($deletedImages, $project);
        }
        $this->saveClients($clients, $project);
        $this->saveTags($tags, $project);

        $project->update($data);

        return new ProjectResource($project);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Models\Project $project
     * @return \Illuminate\Http\Response
     */
    public function destroy(Project $project)
    {
        $project->delete();

        return response()->noContent();
    }

    private function saveServices($serviceIds, Project $project)
    {
        ProjectService::where('project_id', $project->id)->delete();
        $data = array_map(fn($id) => (['service_id' => $id, 'project_id' => $project->id]), $serviceIds);

        ProjectService::insert($data);
    }

    private function saveClients($clientIds, Project $project)
    {
        ProjectClient::where('project_id', $project->id)->delete();
        $data = array_map(fn($id) => (['client_id' => $id, 'project_id' => $project->id]), $clientIds);

        ProjectClient::insert($data);
    }

    private function saveTags($tagIds, Project $project)
    {
        ProjectTag::where('project_id', $project->id)->delete();
        $data = array_map(fn($id) => (['tag_id' => $id, 'project_id' => $project->id]), $tagIds);

        ProjectTag::insert($data);
    }

    /**
     *
     *
     * @param UploadedFile[] $images
     * @return string
     * @throws \Exception
     */
    private function saveImages($images, $positions, Project $project)
    {
        foreach ($positions as $id => $position) {
            ProjectImage::query()
                ->where('id', $id)
                ->update(['position' => $position]);
        }

        foreach ($images as $id => $image) {
            $path = 'images/' . Str::random();
            if (!Storage::exists($path)) {
                Storage::makeDirectory($path, 0755, true);
            }
            $name = Str::random().'.'.$image->getClientOriginalExtension();
            if (!Storage::putFileAS('public/' . $path, $image, $name)) {
                throw new \Exception("Unable to save file \"{$image->getClientOriginalName()}\"");
            }
            $relativePath = $path . '/' . $name;

            ProjectImage::create([
                'project_id' => $project->id,
                'path' => $relativePath,
                'url' => URL::to(Storage::url($relativePath)),
                'mime' => $image->getClientMimeType(),
                'size' => $image->getSize(),
                'position' => $positions[$id] ?? $id + 1
            ]);
        }
    }

    private function deleteImages($imageIds, Project $project)
    {
        $images = ProjectImage::query()
            ->where('project_id', $project->id)
            ->whereIn('id', $imageIds)
            ->get();

        foreach ($images as $image) {
            // If there is an old image, delete it
            if ($image->path) {
                Storage::deleteDirectory('/public/' . dirname($image->path));
            }
            $image->delete();
        }
    }
}
