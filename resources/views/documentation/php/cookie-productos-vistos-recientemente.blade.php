<x-app-layout>
<div class="mt-28">
    <div class="container mx-auto p-6">
        <h1 class="text-3xl font-bold text-center mb-6">Documentación - Funcionalidad de Productos Vistos Recientemente (Cookies + Blade Components)</h1>

        {{-- 1. Descripción General --}}
        <section class="mb-8">
            <h2 class="text-2xl font-semibold text-blue-600 mb-4">1. Descripción General</h2>
            <p class="text-lg mb-4">
                Se implementó una funcionalidad para mostrar los <strong>productos vistos recientemente</strong> por el usuario, almacenando sus IDs en una <strong>cookie persistente</strong>. Esta lista se recupera y se muestra dinámicamente en la home del sitio mediante un <strong>Blade Component</strong>.
            </p>
        </section>

        {{-- 2. Componente RecentlyViewed --}}
        <section class="mb-8">
            <h2 class="text-2xl font-semibold text-blue-600 mb-4">2. Componente: <code>RecentlyViewed</code></h2>
            <p class="text-lg mb-4">
                Componente Blade que recibe una colección de productos y los renderiza en la vista.
            </p>
            <pre class="bg-gray-800 text-white p-4 rounded-lg overflow-x-auto"><code>
namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class RecentlyViewed extends Component
{
    public $viewedProducts;

    public function __construct($viewedProducts)
    {
        $this->viewedProducts = $viewedProducts;
    }

    public function render(): View|Closure|string
    {
        return view('components.recently-viewed');
    }
}
            </code></pre>
            <p class="text-lg mt-4">Vista: <code>resources/views/components/recently-viewed.blade.php</code></p>
            <pre class="bg-gray-800 text-white p-4 rounded-lg overflow-x-auto"><code>
&lt;section id="anunciantes_destacados"&gt;
    &lt;div class="container flex flex-col gap-8"&gt;
        '@ if($viewedProducts->count() &gt; 0)''
            &lt;div class="anunciantes_destacados_title"&gt;
                &lt;h3&gt;Vistos recientemente&lt;/h3&gt;
            &lt;/div&gt;
            @ foreach ($ viewedProducts as $ viewedProduct)
                &lt;h6&gt;" $ viewedProduct->title "&lt;/h6&gt;
            @ endforeach
        '@ endif'
    &lt;/div&gt;
&lt;/section&gt;
            </code></pre>
        </section>

        {{-- 3. Modificación ProductController --}}
        <section class="mb-8">
            <h2 class="text-2xl font-semibold text-blue-600 mb-4">3. Modificación: <code>ProductController@view</code></h2>
            <p class="text-lg mb-4">Se añadió la lógica para actualizar la cookie <code>recently_viewed</code> con el ID del producto visitado.</p>
            <pre class="bg-gray-800 text-white p-4 rounded-lg overflow-x-auto"><code>
use Illuminate\Support\Facades\Cookie;

public function view($categorySlug, $subcategorySlug, $productSlug)
{
    // Obtener categoría, subcategoría y producto...
    // (código omitido)

    // --- Lógica para la cookie ---
    $viewedProducts = json_decode(Cookie::get('recently_viewed'), true) ?? [];

    // Eliminar duplicados
    $viewedProducts = array_filter($viewedProducts, fn($id) =&gt; $id != $product->id);

    // Insertar el actual al inicio
    array_unshift($viewedProducts, $product->id);

    // Limitar a 5
    $viewedProducts = array_slice($viewedProducts, 0, 5);

    // Guardar cookie por 7 días
    Cookie::queue('recently_viewed', json_encode($viewedProducts), 60 * 24 * 7);

    // Retornar vista
    return view('product.view', [...]);
}
            </code></pre>
        </section>

        {{-- 4. Modificación WelcomeController --}}
        <section class="mb-8">
            <h2 class="text-2xl font-semibold text-blue-600 mb-4">4. Modificación: <code>WelcomeController@index</code></h2>
            <p class="text-lg mb-4">Se recuperan los productos almacenados en la cookie para enviarlos a la vista principal.</p>
            <pre class="bg-gray-800 text-white p-4 rounded-lg overflow-x-auto"><code>
use Illuminate\Support\Facades\Cookie;

public function index()
{
    // Datos home (banners, categorías, artículos...)
    // (código omitido)

    $viewedProductsIds = json_decode(Cookie::get('recently_viewed'), true) ?? [];
    
    $viewedProducts = count($viewedProductsIds) &gt; 0
        ? Product::whereIn('id', $viewedProductsIds)
            ->orderByRaw('FIELD(id, ' . implode(',', $viewedProductsIds) . ')')
            ->get()
        : collect();

    return view('welcome', compact(
        'homeherobanners',
        'categories',
        'anunciantes_destacados',
        'ultimos_anunciantes',
        'articles',
        'viewedProducts'
    ));
}
            </code></pre>
        </section>

        {{-- 5. Inclusión en la Vista --}}
        <section class="mb-8">
            <h2 class="text-2xl font-semibold text-blue-600 mb-4">5. Inclusión en la Vista</h2>
            <p class="text-lg mb-4">Se incluyó el componente en la home para mostrar los productos vistos.</p>
            <pre class="bg-gray-800 text-white p-4 rounded-lg overflow-x-auto"><code>
&lt;x-recently-viewed :viewedProducts="$viewedProducts" /&gt;
            </code></pre>
        </section>

        {{-- 6. Flujo Resumido --}}
        <section class="mb-8">
            <h2 class="text-2xl font-semibold text-blue-600 mb-4">6. Flujo Resumido</h2>
            <ul class="list-disc pl-6 text-lg">
                <li>Al visitar un producto, se guarda su ID en una cookie (<code>recently_viewed</code>).</li>
                <li>En la página principal, se leen los IDs de esa cookie.</li>
                <li>Se consultan esos productos en la base de datos y se envían a la vista.</li>
                <li>El componente <code>RecentlyViewed</code> renderiza los productos vistos.</li>
                <li>La cookie se mantiene persistente por 7 días.</li>
            </ul>
        </section>

        {{-- 7. Conclusión --}}
        <section>
            <h2 class="text-2xl font-semibold text-blue-600 mb-4">7. Conclusión</h2>
            <p class="text-lg mb-4">
                Esta implementación simple y eficiente permite mejorar la experiencia del usuario mostrando sus productos vistos recientemente sin necesidad de autenticación, usando cookies como almacenamiento local y componentes Blade para mantener la separación de responsabilidades.
            </p>
        </section>
    </div>
</div>
</x-app-layout>

<style>
    code {
        display: block;
        width: auto;
    }
</style>
