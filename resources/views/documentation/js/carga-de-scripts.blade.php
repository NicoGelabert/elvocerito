<x-app-layout>
<div class="mt-28">
    <div class="container mx-auto p-6">
        <h1 class="text-3xl font-bold text-center mb-6">Documentación - Optimización de la Carga y Manejo de Scripts (Vue + Alpine + Swiper)</h1>
    
        <section class="mb-8">
            <h2 class="text-2xl font-semibold text-blue-600 mb-4">1. Estructura General</h2>
            <p class="text-lg mb-4">La aplicación utiliza una mezcla de <strong>Vue</strong>, <strong>Alpine.js</strong>, y <strong>Swiper.js</strong> para gestionar la interactividad y las galerías de la página. Todo el código JavaScript está organizado en archivos separados y cargado de manera condicional para optimizar la carga según la página actual.</p>
        </section>
    
        <section class="mb-8">
            <h2 class="text-2xl font-semibold text-blue-600 mb-4">Archivo: <code>app.js</code></h2>
            <p class="text-lg mb-4">Este archivo contiene la configuración general de <strong>Vue</strong> y <strong>Alpine.js</strong>, así como la lógica de carga condicional de los scripts de las vistas.</p>
            <pre class="bg-gray-800 text-white p-4 rounded-lg overflow-x-auto">
                <code>
                    import './bootstrap';
                    import Alpine from 'alpinejs';
                    import collapse from '@alpinejs/collapse';
                    import { get, post } from "./http.js";
                    import 'flowbite';

                    Alpine.plugin(collapse);

                    document.addEventListener("alpine:init", () => {
                    Alpine.data("toast", () => ({
                        visible: false,
                        delay: 5000,
                        percent: 0,
                        interval: null,
                        timeout: null,
                        message: null,
                        close() {
                        this.visible = false;
                        clearInterval(this.interval);
                        },
                        show(message) {
                        this.visible = true;
                        this.message = message;
                        
                        if (this.interval) {
                            clearInterval(this.interval);
                            this.interval = null;
                        }
                        
                        if (this.timeout) {
                            clearTimeout(this.timeout);
                            this.timeout = null;
                        }
                        
                        this.timeout = setTimeout(() => {
                            this.visible = false;
                            this.timeout = null;
                        }, this.delay);
                        const startDate = Date.now();
                        const futureDate = Date.now() + this.delay;
                        this.interval = setInterval(() => {
                            const date = Date.now();
                            this.percent = ((date - startDate) * 100) / (futureDate - startDate);
                            if (this.percent >= 100) {
                            clearInterval(this.interval);
                            this.interval = null;
                            }
                        }, 30);
                        },
                    }));

                    Alpine.data('lightbox', () => ({
                        isOpen: false,
                        imageUrl: '',
                        openLightbox(url) {
                        this.imageUrl = url;
                        this.isOpen = true;
                        }
                    }));
                    });

                    window.Alpine = Alpine;
                    Alpine.start();

                    // 🚀 Cargar scripts según la página
                    document.addEventListener("DOMContentLoaded", () => {
                    
                    // 🚀 Progreso de carga (porcentaje)
                    let percentage = 0;
                    const progressBar = document.getElementById('progress-bar');
                    const interval = setInterval(function() {
                        if (percentage &lt; 100) {
                        percentage += 1;
                        document.getElementById('loader-percentage').innerText = percentage + '%';
                        progressBar.style.width = percentage + '%';
                        } else {
                        clearInterval(interval);
                        document.getElementById('loader-wrapper').style.display = 'none';
                        const content = document.getElementById('body-content');
                        content.style.display = 'block';
                        setTimeout(function() {
                            content.classList.add('fade-in');
                        }, 10);
                        }
                    })

                    const page = document.body.dataset.page;
                    
                    // 🚀 Cargar scripts según la página
                    if (page === 'products.index') {
                        import('./catalog.js');
                    } else if (page === 'welcome') {
                        import('./home.js');
                    }
                    });
                </code>
            </pre>
        </section>
    
        <section class="mb-8">
            <h2 class="text-2xl font-semibold text-blue-600 mb-4">Archivo: <code>catalog.js</code></h2>
            <p class="text-lg mb-4">Este archivo es específico para la <strong>página del catálogo de productos</strong>. En él, se crea una aplicación de Vue que maneja el componente de lista de productos.</p>
            <pre class="bg-gray-800 text-white p-4 rounded-lg overflow-x-auto">
                <code>
                    import { createApp } from 'vue/dist/vue.esm-bundler';
                    import ProductList from './components/products/ProductList.vue';

                    const productIndex = createApp({});
                    productIndex.component('product-list', ProductList);
                    productIndex.mount('#product-index');
                </code>
            </pre>
        </section>
    
        <section class="mb-8">
            <h2 class="text-2xl font-semibold text-blue-600 mb-4">Archivo: <code>home.js</code></h2>
            <p class="text-lg mb-4">Este archivo es específico para la <strong>página de inicio</strong>. En él, se inicializan varias galerías usando <strong>Swiper.js</strong> (Home Hero Banner, Últimos Anunciantes, y News).</p>
            <pre class="bg-gray-800 text-white p-4 rounded-lg overflow-x-auto">
                <code>
                    
                </code>
            </pre>
        </section>
    
        <section class="mb-8">
            <h2 class="text-2xl font-semibold text-blue-600 mb-4">Archivo: <code>app.blade.php</code></h2>
            <p class="text-lg mb-4">Este archivo Blade es el contenedor de las vistas y se asegura de pasar la información necesaria (nombre de la página) para cargar los scripts correspondientes. El <code>data-page</code> se usa para identificar qué página está siendo mostrada, lo que permite cargar los scripts de manera condicional.</p>
            <pre class="bg-gray-800 text-white p-4 rounded-lg overflow-x-auto">
                <code>
                    &lt;body data-page="{{ request()->route()->getName() ?? '' }}"&gt;
                    &lt;!-- Aquí va el contenido de la página --&gt;
                    &lt;/body&gt;
                </code>
            </pre>
        </section>
    
        <section class="mb-8">
            <h2 class="text-2xl font-semibold text-blue-600 mb-4">Resumen del flujo de carga</h2>
            <ul class="list-disc pl-6 text-lg">
                <li><strong>Alpine.js:</strong> Se inicializan y configuran los componentes <code>toast</code> (notificaciones) y <code>lightbox</code> (galería de imágenes).</li>
                <li><strong>Carga condicional de scripts:</strong> Según el nombre de la página (<code>data-page</code>), se cargan los scripts correspondientes:</li>
                    <ul class="list-inside pl-4">
                        <li><code>catalog.js</code> para el catálogo de productos.</li>
                        <li><code>home.js</code> para la página de inicio, donde se inicializan las galerías con <strong>Swiper.js</strong>.</li>
                    </ul>
                <li><strong>Cargar progreso:</strong> Se muestra un progreso de carga mientras se espera que la página se cargue por completo.</li>
            </ul>
        </section>
    
        <section>
            <h2 class="text-2xl font-semibold text-blue-600 mb-4">Conclusión</h2>
            <p class="text-lg mb-4">Este enfoque modular asegura que solo los scripts necesarios se carguen en cada página, lo que mejora el rendimiento general de la aplicación y proporciona una experiencia más fluida para el usuario. Además, se mantiene la estructura limpia y organizada, facilitando el mantenimiento y la escalabilidad del proyecto.</p>
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