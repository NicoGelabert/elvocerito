<x-app-layout>
    <div class="mt-28">
        <div class="container mx-auto p-6">
            <h1 class="text-3xl font-bold text-center mb-6">Documentación - Exportación de Productos, Categorías y Tags a Excel</h1>
            <section class="mb-8">
                <h2 class="text-2xl font-semibold text-blue-600 mb-4">1. Rutas</h2>
                <p class="text-lg mb-4">Se agregaron las siguientes rutas en Laravel:</p>
                <pre class="bg-gray-800 text-white p-4 rounded-lg overflow-x-auto">
<code>
    Route::get('/export-products', [ProductController::class, 'exportProducts']);
    Route::get('/export-categories', [CategoryController::class, 'exportCategories']);
    Route::get('/export-tags', [TagController::class, 'exportTags']);
</code>
                </pre>
            </section>
        
            <section class="mb-8">
                <h2 class="text-2xl font-semibold text-blue-600 mb-4">2. Controladores</h2>
                <p class="text-lg mb-4">Cada controlador implementa su función de exportación utilizando Laravel Excel:</p>
                <pre class="bg-gray-800 text-white p-4 rounded-lg overflow-x-auto">
<code>
    public function exportCategories()
    {
        return Excel::download(new CategoriesExport, 'categorias.xlsx');
    }

    public function exportProducts()
    {
        return Excel::download(new ProductsExport, 'productos.xlsx');
    }

    public function exportTags()
    {
        return Excel::download(new TagsExport, 'tags.xlsx');
    }
</code>
                </pre>
            </section>
        
            <section class="mb-8">
                <h2 class="text-2xl font-semibold text-blue-600 mb-4">3. Exports (Laravel Excel)</h2>
                <p class="text-lg mb-4">Se crearon los archivos correspondientes en <code>App\Exports</code> para cada entidad:</p>
                <ul class="list-disc pl-6 text-lg">
                    <li><code>ProductsExport.php</code></li>
                    <li><code>CategoriesExport.php</code></li>
                    <li><code>TagsExport.php</code></li>
                </ul>
                <p class="text-lg mt-4">Cada export utiliza FromCollection o FromQuery y un map() para filtrar y formatear los datos.</p>
                <pre class="bg-gray-800 text-white p-4 rounded-lg overflow-x-auto">
<code>
    public function map($category): array
    {
        return [
            $category->id,
            $category->name,
            $category->active ? 'Sí' : 'No',
            $category->parent ? $category->parent->name : 'Categoría Principal',
            $category->products_count,
        ];
    }
</code>
                </pre>
            </section>

            <section class="mb-8">
                <h2 class="text-2xl font-semibold text-blue-600 mb-4">4. Vue Component - Botón Reutilizable</h2>
                <p class="text-lg mb-4">Se creó un componente Vue 3 reutilizable para la descarga de Excel:</p>
                <pre class="bg-gray-800 text-white p-4 rounded-lg overflow-x-auto">
<code>
    // ExportButton.vue
    &lt;template&gt;
    &lt;div class="flex flex-col items-center justify-center"&gt;
    &lt;button
    @click="downloadExcel"
    class="flex items-center gap-2 p-2 text-xs bg-gray-200 border border-gray-300 rounded-md text-gray-700"
    &gt;
    Descargar Excel
    &lt;ArrowDownTrayIcon class="h-3 w-3" /&gt;
    &lt;/button&gt;
    &lt;/div&gt;
    &lt;/template&gt;

    &lt;script setup&gt;
    import { ArrowDownTrayIcon } from '@heroicons/vue/24/outline';
    import axiosClient from '../../axios';
    const props = defineProps({
        url: {
            type: String,
            required: true
        },
        filename: {
            type: String,
            required: true
        },
        label: {
            type: String,
            default: 'Descargar Excel'
        }
    });

    const downloadExcel = async () =&gt; {
        try {
            const response = await axiosClient.get(props.url, {
                responseType: 'blob'
            });
            const blob = new Blob([response.data]);
            const url = window.URL.createObjectURL(blob);
            const link = document.createElement('a');
            link.href = url;
            link.setAttribute('download', props.filename);
            document.body.appendChild(link);
            link.click();
        } catch (error) {
            console.error(`Error descargando ${props.filename}:`, error);
        }
    };
    &lt;/script&gt;
</code>
                </pre>
            </section>
            <section class="mb-8">
                <h2 class="text-2xl font-semibold text-blue-600 mb-4">5. Uso del componente</h2>
                <p class="text-lg mb-4">Ejemplo de cómo utilizar el componente para Productos, Categorías y Tags:</p>
                <pre class="bg-gray-800 text-white p-4 rounded-lg overflow-x-auto">
<code>
    &lt;template&gt;
    &lt;div class="space-y-4"&gt;
    &lt;ExportButton
    url="/export-products"
    filename="productos.xlsx"
    label="Descargar Productos"
    /&gt;

    &lt;ExportButton
    url="/export-categories"
    filename="categorias.xlsx"
    label="Descargar Categorías"
    /&gt;

    &lt;ExportButton
    url="/export-tags"
    filename="tags.xlsx"
    label="Descargar Tags"
    /&gt;
    &lt;/div&gt;
    &lt;/template&gt;

    &lt;script setup&gt;
    import ExportButton from '@/components/ExportButton.vue';
    &lt;/script&gt;
</code>
                </pre>
            </section>

            <section class="mb-8">
                <h2 class="text-2xl font-semibold text-blue-600 mb-4">6. Ejemplo en documentación</h2>
                <p class="text-lg mb-4">En la documentación siempre se debe mostrar el uso del botón con valores de ejemplo:</p>
                <pre class="bg-gray-800 text-white p-4 rounded-lg overflow-x-auto">
<code>
    &lt;ExportButton
    url="/export-ejemplo"
    filename="ejemplo.xlsx"
    label="Descargar Ejemplo"
    /&gt;
</code>
                </pre>
                <p class="text-lg mt-4">Esto evita errores de props no definidas en ejemplos estáticos.</p>
            </section>
        
            <section>
                <h2 class="text-2xl font-semibold text-blue-600 mb-4">Conclusión</h2>
                <p class="text-lg mb-4">Este flujo permite descargar listados de productos, categorías y tags en formato Excel de forma eficiente, reutilizando un solo componente Vue y manteniendo el backend limpio con Laravel Excel. La solución es escalable y fácil de mantener.</p>
            </section>
        </div>
    </div>
</x-app-layout>

<style>
    code{
        display:block;
        width:auto;
    }
</style>
