<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\ArticleRequest;
use App\Http\Resources\ArticleListResource;
use App\Http\Resources\ArticleResource;
use App\Models\Api\Article;
use App\Models\ArticleImage;
use App\Models\ArticleAuthor;
use App\Models\ArticleTag;
use App\Models\ArticleItem;
use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Str;

class ArticleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $perPage = $request->get('per_page');
        $search = $request->get('search', '');

        $query = Article::query()->with(['authors'])
            ->where('title', 'like', "%{$search}%");

        $sortField = $request->get('sort_field', 'created_at');
        $sortDirection = $request->get('sort_direction', 'desc');

        $query->orderBy($sortField, $sortDirection);

        return ArticleListResource::collection($query->paginate($perPage));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(ArticleRequest $request)
    {
        $data = $request->validated();
        $data['created_by'] = $request->user()->id;
        $data['updated_by'] = $request->user()->id;

        /** @var \Illuminate\Http\UploadedFile[] $images */
        $images = $data['images'] ?? [];
        $imagePositions = $data['image_positions'] ?? [];
        $authors = $data['authors'] ?? [];
        $tags = $data['tags'] ?? [];
        $items = $data['items'] ?? [];

        $article = Article::create($data);



        $this->saveImages($images, $imagePositions, $article);
        $this->saveAuthors($authors, $article);
        $this->saveTags($tags, $article);
        $this->saveItems($items, $article);

        return new ArticleResource($article);
    }

    /**
     * Display the specified resource.
     *
     * @param \App\Models\Article $article
     * @return \Illuminate\Http\Response
     */
    public function show(Article $article)
    {
        return new ArticleResource($article);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Article      $article
     * @return \Illuminate\Http\Response
     */
    public function update(ArticleRequest $request, Article $article)
    {
        $data = $request->validated();
        $data['updated_by'] = $request->user()->id;
        $authors = $data['authors'] ?? [];

        /** @var \Illuminate\Http\UploadedFile[] $images */
        $images = $data['images'] ?? [];
        $deletedImages = $data['deleted_images'] ?? [];
        $imagePositions = $data['image_positions'] ?? [];
        $tags = $data['tags'] ?? [];
        $items = $data['items'] ?? [];

        $this->saveImages($images, $imagePositions, $article);
        if (count($deletedImages) > 0) {
            $this->deleteImages($deletedImages, $article);
        }
        $this->saveAuthors($authors, $article);
        $this->saveTags($tags, $article);
        $this->saveItems($items, $article);

        $article->update($data);

        return new ArticleResource($article);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Models\Article $article
     * @return \Illuminate\Http\Response
     */
    public function destroy(Article $article)
    {
        $article->delete();

        return response()->noContent();
    }

    private function saveAuthors($authorIds, Article $article)
    {
        ArticleAuthor::where('article_id', $article->id)->delete();
        $data = array_map(fn($id) => (['author_id' => $id, 'article_id' => $article->id]), $authorIds);

        ArticleAuthor::insert($data);
    }

    private function saveTags($tagIds, Article $article)
    {
        ArticleTag::where('article_id', $article->id)->delete();
        $data = array_map(fn($id) => (['tag_id' => $id, 'article_id' => $article->id]), $tagIds);

        ArticleTag::insert($data);
    }

    private function saveItems(array $items, Article $article)
    {
        $article->items()->delete(); 

        foreach ($items as $item) {
            $article->items()->create($item);
        }
    }

    /**
     *
     *
     * @param UploadedFile[] $images
     * @return string
     * @throws \Exception
     */
    private function saveImages($images, $positions, Article $article)
    {
        foreach ($positions as $id => $position) {
            ArticleImage::query()
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

            ArticleImage::create([
                'article_id' => $article->id,
                'path' => $relativePath,
                'url' => URL::to(Storage::url($relativePath)),
                'mime' => $image->getClientMimeType(),
                'size' => $image->getSize(),
                'position' => $positions[$id] ?? $id + 1
            ]);
        }
    }

    private function deleteImages($imageIds, Article $article)
    {
        $images = ArticleImage::query()
            ->where('article_id', $article->id)
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
