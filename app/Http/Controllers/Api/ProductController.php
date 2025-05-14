<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\ProductRequest;
use App\Http\Resources\ProductListResource;
use App\Http\Resources\ProductResource;
use App\Models\Api\Product;
use App\Models\ProductCategory;
use App\Models\ProductImage;
use App\Models\ProductAlergen;
use App\Models\ProductContact;
use App\Models\ProductSocial;
use App\Models\ProductAddress;
use App\Models\ProductTag;
use App\Models\ProductHorario;
use App\Models\ProductWeb;
use App\Models\ProductListitem;
use App\Models\Api\Category;
use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Str;
use App\Exports\ProductsExport;
use Maatwebsite\Excel\Facades\Excel;

class ProductController extends Controller
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
        $categorySlug = $request->get('category', '');  // Agregar parámetro category

        $query = Product::query()->with(['categories'])
            ->where('title', 'like', "%{$search}%");

        // Filtrar por categoría si se pasa el slug de la categoría
        if ($categorySlug) {
            $query->whereHas('categories', function ($query) use ($categorySlug) {
                $query->where('slug', $categorySlug);
            });
        }

        $sortField = $request->get('sort_field', 'created_at');
        $sortDirection = $request->get('sort_direction', 'desc');

        $query->orderBy($sortField, $sortDirection);

        return ProductListResource::collection($query->paginate($perPage));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(ProductRequest $request)
    {
        $data = $request->validated();
        $data['created_by'] = $request->user()->id;
        $data['updated_by'] = $request->user()->id;

        /** @var \Illuminate\Http\UploadedFile[] $images */
        $categories = $data['categories'] ?? [];
        
        $images = $data['images'] ?? [];
        $imagePositions = $data['image_positions'] ?? [];
        
        $contacts = $data['contacts'] ?? [];

        $socials = $data['socials'] ?? [];

        $addresses = $data['addresses'] ?? [];

        $tags = $data['tags'] ?? [];

        $horarios = $data['horarios'] ?? [];

        $webs = $data['webs'] ?? [];

        $listitems = $data['listitems'] ?? [];

        $product = Product::create($data);

        $this->saveCategories($categories, $product);
        $this->saveImages($images, $imagePositions, $product);
        $this->saveContacts($contacts, $product);
        $this->saveSocials($socials, $product);
        $this->saveAddresses($addresses, $product);
        $this->saveTags($tags, $product);
        $this->saveHorarios($horarios, $product);
        $this->saveWebs($webs, $product);
        $this->saveListitems($listitems, $product);

        return new ProductResource($product);
    }

    /**
     * Display the specified resource.
     *
     * @param \App\Models\Product $product
     * @return \Illuminate\Http\Response
     */
    public function show(Product $product)
    {
        return new ProductResource($product);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Product      $product
     * @return \Illuminate\Http\Response
     */
    public function update(ProductRequest $request, Product $product)
    {
        $data = $request->validated();
        $data['updated_by'] = $request->user()->id;
        
        $categories = $data['categories'] ?? [];

        /** @var \Illuminate\Http\UploadedFile[] $images */
        $images = $data['images'] ?? [];
        $deletedImages = $data['deleted_images'] ?? [];
        $imagePositions = $data['image_positions'] ?? [];

        $contacts = $data['contacts'] ?? [];

        $socials = $data['socials'] ?? [];

        $addresses = $data['addresses'] ?? [];

        $tags = $data['tags'] ?? [];

        $horarios = $data['horarios'] ?? [];

        $webs = $data['webs'] ?? [];

        $listitems = $data['listitems'] ?? [];

        $this->saveCategories($categories, $product);
        $this->saveImages($images, $imagePositions, $product);
        if (count($deletedImages) > 0) {
            $this->deleteImages($deletedImages, $product);
        }
        $this->saveContacts($contacts, $product);
        $this->saveSocials($socials, $product);
        $this->saveAddresses($addresses, $product);
        $this->saveTags($tags, $product);
        $this->saveHorarios($horarios, $product);
        $this->saveWebs($webs, $product);
        $this->saveListitems($listitems, $product);

        $product->update($data);

        return new ProductResource($product);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Models\Product $product
     * @return \Illuminate\Http\Response
     */
    public function destroy(Product $product)
    {
        $product->delete();

        return response()->noContent();
    }

    private function saveCategories($categoryIds, Product $product)
    {
        ProductCategory::where('product_id', $product->id)->delete();
        $data = array_map(fn($id) => (['category_id' => $id, 'product_id' => $product->id]), $categoryIds);

        ProductCategory::insert($data);
    }

    /**
     *
     *
     * @param UploadedFile[] $images
     * @return string
     * @throws \Exception
     */
    private function saveImages($images, $positions, Product $product)
    {
        foreach ($positions as $id => $position) {
            ProductImage::query()
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

            ProductImage::create([
                'product_id' => $product->id,
                'path' => $relativePath,
                'url' => URL::to(Storage::url($relativePath)),
                'mime' => $image->getClientMimeType(),
                'size' => $image->getSize(),
                'position' => $positions[$id] ?? $id + 1
            ]);
        }
    }

    private function deleteImages($imageIds, Product $product)
    {
        $images = ProductImage::query()
            ->where('product_id', $product->id)
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

    protected function saveContacts(array $contacts, Product $product)
    {
        $product->contacts()->delete(); // Limpia precios existentes para simplificar la actualización

        foreach ($contacts as $contact) {
            $product->contacts()->create($contact); // Esto usará la relación hasMany para crear los precios
        }
    }

    protected function saveSocials(array $socials, Product $product)
    {
        $product->socials()->delete(); 

        foreach ($socials as $social) {
            $product->socials()->create($social);
        }
    }

    protected function saveAddresses(array $addresses, Product $product)
    {
        $product->addresses()->delete(); 

        foreach ($addresses as $address) {
            $product->addresses()->create($address);
        }
    }

    private function saveTags($tagIds, Product $product)
    {
        ProductTag::where('product_id', $product->id)->delete();
        $data = array_map(fn($id) => (['tag_id' => $id, 'product_id' => $product->id]), $tagIds);

        ProductTag::insert($data);
    }

    protected function saveHorarios(array $horarios, Product $product)
    {
        $product->horarios()->delete(); 

        foreach ($horarios as $horario) {
            $product->horarios()->create($horario);
        }
    }

    protected function saveWebs(array $webs, Product $product)
    {
        $product->webs()->delete(); 

        foreach ($webs as $web) {
            $product->webs()->create($web);
        }
    }

    protected function saveListitems(array $listitems, Product $product)
    {
        $product->listitems()->delete(); 

        foreach ($listitems as $listitem) {
            $product->listitems()->create($listitem);
        }
    }

    public function productsByCategory($categorySlug)
    {
        // Buscar la categoría por el slug
        $category = Category::where('slug', $categorySlug)->first();

        // Si la categoría no existe, devolvemos una respuesta de error
        if (!$category) {
            return response()->json(['error' => 'Categoría no encontrada'], 404);
        }

        // Obtener los productos asociados a la categoría
        $products = $category->products()->with(['categories', 'contacts', 'social', 'address', 'tags'])->get();

        // Retornar los productos usando el recurso ProductListResource
        return ProductListResource::collection($products);
    }

    public function exportProducts()
    {    
        return Excel::download(new ProductsExport, 'productos.xlsx');
    }
}
