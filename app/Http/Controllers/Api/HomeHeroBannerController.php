<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\HomeHeroBannerRequest;
use App\Http\Resources\HomeHeroBannerListResource;
use App\Http\Resources\HomeHeroBannerResource;
use App\Models\Api\HomeHeroBanner;
use App\Models\HomeHeroBannerTag;
use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Str;

class HomeHeroBannerController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $perPage = request('per_page', 10);
        $search = request('search', '');
        $sortField = request('sort_field', 'created_at');
        $sortDirection = request('sort_direction', 'desc');


        $query = HomeHeroBanner::query()
            ->where('headline', 'like', "%{$search}%")
            ->orderBy($sortField, $sortDirection)
            ->paginate($perPage);


        return HomeHeroBannerListResource::collection($query);
    }

    /**
     * Store a newly created resource in storage.
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */


    public function store(HomeHeroBannerRequest $request)
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

        $tags = $data['tags'] ?? [];

        $homeherobanner = HomeHeroBanner::create($data);

        $this->saveTags($tags, $homeherobanner);

        return new HomeHeroBannerResource($homeherobanner);
    }

    /**
     * Display the specified resource.
     * @param \App\Models\HomeHeroBanner $homeherobanner
     * @return \Illuminate\Http\Response
     */
    public function show(HomeHeroBanner $homeherobanner)
    {
        return new HomeHeroBannerResource($homeherobanner);
    }

    /**
     * Update the specified resource in storage.
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\HomeHeroBanner      $homeherobanner
     * @return \Illuminate\Http\Response
     */
    public function update(HomeHeroBannerRequest $request, HomeHeroBanner $homeherobanner)
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
            if ($homeherobanner->image) {
                Storage::deleteDirectory('/public/' . dirname($homeherobanner->image));
            }
        }

        $tags = $data['tags'] ?? [];

        $this->saveTags($tags, $homeherobanner);

        $homeherobanner->update($data);

        return new HomeHeroBannerResource($homeherobanner);
    }

    /**
     * Remove the specified resource from storage.
     * @param \App\Models\HomeHeroBanner $homeherobanner
     * @return \Illuminate\Http\Response
     */
    public function destroy(HomeHeroBanner $homeherobanner)
    {
        $homeherobanner->delete();

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

    private function saveTags($tagIds, HomeHeroBanner $homeherobanner)
    {
        HomeHeroBannerTag::where('home_hero_banner_id', $homeherobanner->id)->delete();
        $data = array_map(fn($id) => (['tag_id' => $id, 'home_hero_banner_id' => $homeherobanner->id]), $tagIds);

        HomeHeroBannerTag::insert($data);
    }
}
