<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;

class ProductController extends Controller
{
    public function index()
    {
        $query = Product::query();

        if (request()->has('category') && request('category')) {
            $categorySlug = request('category');
            $query->whereHas('categories', function ($q) use ($categorySlug) {
                $q->where('slug', $categorySlug);
            });
        }
        // Filtro por urgencias
        if (request()->has('urgencies') && request('urgencies') == 'true') {
            $query->where('urgencies', true); // o el campo que uses, como 'is_urgent'
        }
        if (request()->has('has_reviews') && request('has_reviews') == 'true') {
            $query->whereHas('reviews', function ($q){
                $q->where('published', true);
            });
        }

        // ───── Farmacias de turno (con horario real) ─────
        if (request('on_duty') === 'true') {

            $now = \Carbon\Carbon::now();

            $query->whereHas('pharmacy.shifts', function ($q) use ($now) {

                $q->where(function ($sub) use ($now) {

                    // Turnos normales (mismo día)
                    $sub->whereRaw("
                        CONCAT(shift_date, ' ', start_time) <= ?
                        AND
                        CONCAT(shift_date, ' ', end_time) >= ?
                    ", [$now, $now]);

                })->orWhere(function ($sub) use ($now) {

                    // Turnos que cruzan de día (end_time < start_time)
                    $sub->whereRaw("
                        CONCAT(shift_date, ' ', start_time) <= ?
                        AND
                        CONCAT(DATE_ADD(shift_date, INTERVAL 1 DAY), ' ', end_time) >= ?
                        AND end_time < start_time
                    ", [$now, $now]);

                });
            });
        }

        if (request()->expectsJson()) {

            $products = $query->where('published', 1)
                ->with(['categories', 'images', 'contacts', 'socials', 'horarios', 'pharmacy.shifts'])
                ->paginate(16); // Número de resultados por página

            // Transformar cada item manteniendo la metadata
            $products->getCollection()->transform(function ($product) {
                return array_merge($product->toArray(), [
                    'categories' => $product->categories->sortBy('id')->values(),
                    'image_url' => $product->images->first()->url ?? 'storage/common/noimage.png',
                    'contacts' => $product->contacts->map(fn($c) => [
                        'id' => $c->id,
                        'type' => $c->type,
                        'info' => $c->info,
                    ]),
                    'socials' => $product->socials->map(fn($s) => [
                        'id' => $s->id,
                        'type' => $s->rrss,
                        'info' => $s->link,
                    ]),
                    'horarios' => $product->horarios->map(fn($h) => [
                        'dia' => mb_strtolower($h->dia),
                        'apertura' => \Carbon\Carbon::parse($h->apertura)->format('H:i'),
                        'cierre' => \Carbon\Carbon::parse($h->cierre)->format('H:i'),
                    ])->values(),
                ]);
            });

            return response()->json([
                'products' => $products
            ]);
        }

        return $this->renderProducts($query);
    }

    public function byCategory(Category $category)
    {
        $categories = Category::getAllChildrenByParent($category);

        $query = Product::query()
            ->select('products.*')
            ->join('product_categories AS pc', 'pc.product_id', 'products.id')
            ->whereIn('pc.category_id', array_map(fn($c) => $c->id, $categories));

        return $this->renderProducts($query);
    }

    public function view($categorySlug, $productSlug)
    {
        // Obtener la categoría usando el slug
        $category = Category::where('slug', $categorySlug)->firstOrFail();

        // Obtener el producto con el count de reseñas usando el slug
        $product = Product::withCount('reviews')->where('slug', $productSlug)->firstOrFail();

        // Cargar el producto con sus relaciones
        $product->load(['categories', 'images', 'contacts', 'socials', 'addresses', 'horarios']);

        // Obtener los productos relacionados (si es necesario)
        $tags = $product->tags()->get();

        // --- Lógica para la cookie ---
        $viewedProducts = json_decode(Cookie::get('recently_viewed'), true) ?? [];

        // Remover el producto si ya está en la lista (para evitar duplicados)
        $viewedProducts = array_filter($viewedProducts, fn($id) => $id != $product->id);

        // Agregar el producto actual al inicio
        array_unshift($viewedProducts, $product->id);

        // Limitar a los últimos 5 productos
        $viewedProducts = array_slice($viewedProducts, 0, 5);

        // Guardar la cookie (duración: 7 días)
        Cookie::queue('recently_viewed', json_encode($viewedProducts), 60 * 24 * 7);

        // Retornar la vista con la información necesaria
        return view('product.view', [
            'product' => $product,
            'category' => $category,
            'tags' => $tags,
        ]);
    }


    public function urgencies(Product $products, Category $categories)
    {
        // Obtener los productos con las relaciones necesarias
        $products = Product::query()->where('urgencies', 1)
            ->with(['categories', 'images', 'contacts', 'socials', 'addresses']) // Sin categorías
            ->get();
            
        $categories = $products->pluck('categories')->flatten()->unique('id');
        $tags = $products->pluck('tags')->flatten()->unique('id');
        // Pasar solo los productos a la vista
        return view('product.urgencies', compact('products', 'categories', 'tags'));
    }

    private function renderProducts(Builder $query)
    {
        $search = \request()->get('search');
        $sort = \request()->get('sort', '-updated_at');
        $categorySlug = request()->get('category');

        if ($sort) {
            $sortDirection = 'asc';
            if ($sort[0] === '-') {
                $sortDirection = 'desc';
            }
            $sortField = preg_replace('/^-?/', '', $sort);

            $query->orderBy($sortField, $sortDirection);
        }
        $products = $query
            ->where('published', '=', 1)
            ->where(function ($query) use ($search) {
                /** @var $query \Illuminate\Database\Eloquent\Builder */
                $query->where('products.title', 'like', "%$search%")
                    ->orWhere('products.description', 'like', "%$search%");
            })

            ->paginate(5);

        return view('product.index', [
            'products' => $products,
            'category' => $categorySlug,
        ]);

    }

}
