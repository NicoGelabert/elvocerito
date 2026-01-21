<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreTagRequest;
use App\Http\Requests\UpdateTagRequest;
use App\Http\Resources\TagResource;
use App\Http\Resources\TagTreeResource;
use App\Models\Tag;
use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Str;
use App\Exports\TagsExport;
use Maatwebsite\Excel\Facades\Excel;

class TagController extends Controller
{
    public function index()
    {
        $sortField = request('sort_field', 'updated_at');
        $sortDirection = request('sort_direction', 'desc');

        $tags = Tag::query()
            ->orderBy($sortField, $sortDirection)
            ->latest()
            ->get();

        return TagResource::collection($tags);
    }

    public function getAsTree()
    {
        // Traer todos los tags activos, ordenados alfabéticamente
        $tags = Tag::where('active', 1)
            ->orderBy('name', 'asc')
            ->get();

        // Construir el árbol recursivo
        $tree = $this->buildTree($tags);

        // Aplicar el Resource recursivo
        return TagTreeResource::collection($tree);
    }

    private function buildTree($tags, $parentId = null)
    {
        $branch = [];

        foreach ($tags->where('parent_id', $parentId) as $tag) {
            $children = $this->buildTree($tags, $tag->id);
            if ($children) {
                $tag->setRelation('children', collect($children));
            } else {
                $tag->setRelation('children', collect());
            }
            $branch[] = $tag;
        }

        return $branch;
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreTagRequest $request)
    {
        $data = $request->validated();
        $data['created_by'] = $request->user()->id;
        $data['updated_by'] = $request->user()->id;

        /** @var \Illuminate\Http\UploadedFile $image */
        $image = $data['image'] ?? null;
        // Check if image was given and save on local file system
        if ($image) {
            $relativePath = $this->saveImage($image);
            $data['image'] = URL::to(Storage::url($relativePath));
            $data['image_mime'] = $image->getClientMimeType();
            $data['image_size'] = $image->getSize();
        }

        $tag = Tag::create($data);

        return new TagResource($tag);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateTagRequest $request, Tag $tag)
    {
        $data = $request->validated();
        $data['updated_by'] = $request->user()->id;

        /** @var \Illuminate\Http\UploadedFile $image */
        $image = $data['image'] ?? null;
        // Check if image was given and save on local file system
        if ($image) {
            $relativePath = $this->saveImage($image);
            $data['image'] = URL::to(Storage::url($relativePath));
            $data['image_mime'] = $image->getClientMimeType();
            $data['image_size'] = $image->getSize();


            // If there is an old image, delete it
            if ($tag->image) {
                Storage::deleteDirectory('/public/' . dirname($tag->image));
            }
        }

        $tag->update($data);

        return new TagResource($tag);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Tag $tag)
    {
        $tag->delete();

        return response()->noContent();
    }

    private function saveImage(UploadedFile $image)
    {
        $path = 'images/' . Str::random();
        if (!Storage::exists($path)) {
            Storage::makeDirectory($path, 0755, true);
        }
        if (!Storage::putFileAS('public/' . $path, $image, $image->getClientOriginalName())) {
            throw new \Exception("Unable to save file \"{$image->getClientOriginalName()}\"");
        }


        return $path . '/' . $image->getClientOriginalName();
    }
    
    public function exportTags()
    {
        return Excel::download(new TagsExport, 'tags.xlsx');
    }
}
