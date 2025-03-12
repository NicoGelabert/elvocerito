<div {{ $attributes->merge(['class' => "search_bar"]) }}>
    <div class="relative">
        <input type="text" name="query" placeholder="Buscá una empresa o servicio" 
            class="search_input">
        <div class="absolute right-3 top-1/2 transform -translate-y-1/2 text-gray-400">
            <x-icons.search />
        </div>
    </div>
    <!-- Contenedor de Resultados -->
     <div class="relative">
         <ul class="search-results absolute w-full bg-white border rounded mt-1 hidden max-h-60 overflow-auto z-50"></ul>
     </div>
</div>

<script>
document.addEventListener("DOMContentLoaded", function() {
    let searchBox = document.querySelector(".search_input");
    let resultsList = document.querySelector(".search-results");

    if (searchBox && resultsList) {
        searchBox.addEventListener("keyup", function() {
            let query = this.value.trim();
            console.log("User is typing: " + query); // Verifica si se está capturando lo que el usuario escribe

            if (query.length > 2) {
                fetch(`/search?query=${query}`)
                    .then(response => response.json())
                    .then(data => {
                        console.log(data); // Verifica los datos que se están recibiendo

                        resultsList.innerHTML = "";
                        resultsList.classList.remove("hidden");

                        if (data.length === 0) {
                            let li = document.createElement("li");
                            li.textContent = "No se encontraron resultados";
                            li.classList.add("p-2", "text-gray-500");
                            resultsList.appendChild(li);
                        } else {
                            data.forEach(product => {
                                let li = document.createElement("li");
                                li.textContent = product.title;
                                li.classList.add("p-2", "cursor-pointer", "hover:bg-gray-200", "text-left");

                                    li.addEventListener("click", () => {
                                        window.location.href = `/categorias/${product.categories?.[0]?.parent?.slug || 'sin-categoria'}/${product.categories?.[0]?.slug || 'sin-subcategoria'}/${product.slug}`;
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
    }
});

</script>