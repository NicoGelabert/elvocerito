<div {{ $attributes->merge(['class' => "search_bar"]) }}>
    <div class="relative flex gap-2 items-center border-b mb-4">
        <div class="text-gray-400">
            <x-icons.search />
        </div>
        <input type="text" name="query" placeholder="Buscá una empresa o servicio" 
            class="search_input" x-ref="searchInput">
        <button type="button" class="clear-search absolute right-2 text-gray-400 hover:text-gray-600 hidden">
            ✖
        </button>
    </div>
    <!-- Contenedor de Resultados -->
     <div class="relative">
         <ul class="search-results divide-y divide-gray-200"></ul>
     </div>
</div>

<script>
document.addEventListener("DOMContentLoaded", function() {
    let searchBox = document.querySelector(".search_input");
    let resultsList = document.querySelector(".search-results");
    let clearButton = document.querySelector(".clear-search");

    if (searchBox && resultsList) {
        searchBox.addEventListener("keyup", function() {
            let query = this.value.trim();
            console.log("User is typing: " + query); // Verifica si se está capturando lo que el usuario escribe

            if (query.length > 0) {
                clearButton.classList.remove("hidden");
            } else {
                clearButton.classList.add("hidden");
            }
            if (query.length > 2) {
                fetch(`/search?query=${query}`)
                    .then(response => response.json())
                    .then(data => {
                        console.log(data); // Verifica los datos que se están recibiendo

                        resultsList.innerHTML = "";
                        resultsList.classList.remove("hidden");

                        if (data.products.length === 0) {
                            let li = document.createElement("li");
                            li.textContent = "No se encontraron resultados";
                            li.classList.add("p-2", "text-gray-500");
                            resultsList.appendChild(li);
                        } else {
                            // Mostrar categorías
                            data.categories.forEach(category => {
                                let li = document.createElement("li");
                                li.classList.add("py-4", "md:p-4", "cursor-pointer", "hover:bg-gray-200", "text-left", "flex", "justify-between", "items-center");

                                // Contenedor de texto con flex y justify-between
                                let wrapper = document.createElement("div");
                                wrapper.classList.add("flex", "gap-2", "items-center");
                                
                                // Imagen
                                const img = document.createElement("img");
                                img.src = category.image || '/placeholder.jpg';
                                img.alt = category.name;
                                img.classList.add("w-4", "h-4");

                                // Texto derecho: nombre de la categoría
                                let name = document.createElement("span");
                                name.textContent = category.name;
                                name.classList.add("search_category_name");

                                // Texto izquierdo: palabra "Categoría"
                                let label = document.createElement("span");
                                label.textContent = "Categoría";
                                label.classList.add("text-gray_500", "text-sm");

                                wrapper.appendChild(img);
                                wrapper.appendChild(name);
                                li.appendChild(wrapper);
                                li.appendChild(label);

                                li.addEventListener("click", () => {
                                    const anunciantes = "{{ route('products.index') }}";
                                    window.location.href = `${anunciantes}?category=${category.slug}`;
                                });

                                resultsList.appendChild(li);
                            });
                            data.products.forEach(product => {
                                let li = document.createElement("li");
                                li.classList.add("py-4", "md:p-4", "cursor-pointer", "hover:bg-gray-200", "text-left", "flex", "items-center", "gap-4");

                                // Imagen
                                const img = document.createElement("img");
                                img.src = product.image || '/placeholder.jpg';
                                img.alt = product.title;
                                img.classList.add("w-12", "h-12", "object-cover", "rounded", "border", "border-gray_400");

                                // Contenedor de texto
                                const info = document.createElement("div");

                                // Título
                                const title = document.createElement("h6");
                                title.textContent = product.title;
                                title.classList.add("font-bold");

                                // Categoría (solo la primera)
                                const category = product.categories?.[0];
                                const categoryText = document.createElement("p");
                                categoryText.textContent = category?.name || '';
                                categoryText.classList.add("text-sm", "text-gray-500");

                                info.appendChild(title);
                                info.appendChild(categoryText);

                                li.appendChild(img);
                                li.appendChild(info);

                                li.addEventListener("click", () => {
                                    window.location.href = `/${category.slug}/${product.slug}`;
                                });

                                resultsList.appendChild(li);
                            });
                        }
                    })
                    .catch(error => console.error("Error en la búsqueda:", error));
            } else {
                resultsList.classList.add("hidden");
            }
        });

        document.addEventListener("click", function(event) {
            if (!searchBox.contains(event.target) && !resultsList.contains(event.target)) {
                resultsList.classList.add("hidden");
            }
        });
        clearButton.addEventListener("click", function () {
            searchBox.value = "";
            clearButton.classList.add("hidden");
            resultsList.innerHTML = "";
            resultsList.classList.add("hidden");
            searchBox.focus();
        });
    }
});

</script>