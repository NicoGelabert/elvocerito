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

    <!-- Sugeridos = anunciantes destacados -->
    <div class="search_list">
        <h4>Servicios sugeridos</h4>
        <div>
            <ul class="divide-y divide-gray-200 suggested-list">
        </div>        
    </div>
    
    <hr class="divider">
    
    <!-- Vistos recientemente -->
    <div id="recents-section" class="search_list" style="display: none;">
        <h4>Vistos recientemente</h4>
        <div>
            <ul class="divide-y divide-gray-200 recent-categories"></ul>
        </div>
        <hr class="divide-y divide-gray-200">
        <div>
            <ul class="divide-y divide-gray-200 recent-products"></ul>
        </div>
    </div>
</div>

<script>
document.addEventListener("DOMContentLoaded", function () {

    const searchBox = document.querySelector(".search_input");
    const resultsList = document.querySelector(".search-results");
    const clearButton = document.querySelector(".clear-search");

    const productsRoute = "{{ route('products.index') }}";

    let debounceTimer = null;
    let selectedIndex = -1;

    /*
    |--------------------------------------------------------------------------
    | HELPERS
    |--------------------------------------------------------------------------
    */

    function navigate(url) {
        window.location.assign(url);
    }

    function attachFastNavigation(link) {
        link.addEventListener("mousedown", function (e) {
            e.preventDefault();
            navigate(link.href);
        });
    }

    function resetSelection() {
        selectedIndex = -1;
    }

    function getItems() {
        return resultsList.querySelectorAll("a.search-result-link");
    }

    function highlightItem(index) {
        const items = getItems();

        items.forEach(item => {
            item.classList.remove("bg-gray-100");
        });

        if (items[index]) {
            items[index].classList.add("bg-gray-100");
            items[index].scrollIntoView({
                block: "nearest"
            });
        }
    }

    function closeResults() {
        resultsList.classList.add("hidden");
        resetSelection();
    }

    function openResults() {
        resultsList.classList.remove("hidden");
    }

    function clearResults() {
        resultsList.innerHTML = "";
        resetSelection();
    }

    /*
    |--------------------------------------------------------------------------
    | ITEM BUILDERS
    |--------------------------------------------------------------------------
    */

    function createCategoryItem(category) {

        const slug =
            category.slug ||
            category.category_slug ||
            category.url_slug;

        const li = document.createElement("li");
        li.className = "py-4 md:p-4 hover:bg-gray-200";

        const a = document.createElement("a");
        a.href = `${slug}`;
        a.className =
            "search-result-link flex justify-between items-center text-left w-full";

        const wrapper = document.createElement("div");
        wrapper.className = "flex gap-2 items-center";

        const img = document.createElement("img");
        img.src = category.image || "/placeholder.jpg";
        img.alt = category.name;
        img.className = "w-4 h-4";

        const name = document.createElement("span");
        name.textContent = category.name;
        name.className = "search_category_name";

        const label = document.createElement("span");
        label.textContent = "Categoría";
        label.className = "text-gray_500 text-sm";

        wrapper.appendChild(img);
        wrapper.appendChild(name);

        a.appendChild(wrapper);
        a.appendChild(label);

        attachFastNavigation(a);

        li.appendChild(a);

        return li;
    }

    function createProductItem(product) {

        const category = product.categories?.[0];
        if (!category) return document.createElement("li");

        const li = document.createElement("li");
        li.className = "py-4 md:p-4 hover:bg-gray-200";

        const a = document.createElement("a");
        a.href = `/${category.slug}/${product.slug}`;
        a.className =
            "search-result-link flex items-center gap-4 text-left w-full";

        const img = document.createElement("img");
        img.src = product.image || "/placeholder.jpg";
        img.alt = product.title;
        img.className =
            "w-12 h-12 object-cover rounded border border-gray_400";

        const info = document.createElement("div");

        const title = document.createElement("h6");
        title.textContent = product.title;
        title.className = "font-bold";

        const categoryText = document.createElement("p");
        categoryText.textContent = category.name || "";
        categoryText.className = "text-sm text-gray-500";

        info.appendChild(title);
        info.appendChild(categoryText);

        a.appendChild(img);
        a.appendChild(info);

        attachFastNavigation(a);

        li.appendChild(a);

        return li;
    }

    /*
    |--------------------------------------------------------------------------
    | RECENTS / SUGGESTED
    |--------------------------------------------------------------------------
    */

    function renderRecents(data) {

        const recentsSection =
            document.getElementById("recents-section");

        const catList =
            document.querySelector(".recent-categories");

        const prodList =
            document.querySelector(".recent-products");

        const hasRecents =
            data.viewedProducts.length > 0 ||
            data.viewedCategories.length > 0;

        recentsSection.style.display =
            hasRecents ? "block" : "none";

        catList.innerHTML = "";
        prodList.innerHTML = "";

        data.viewedCategories.forEach(category => {
            catList.appendChild(
                createCategoryItem(category)
            );
        });

        data.viewedProducts.forEach(product => {
            prodList.appendChild(
                createProductItem(product)
            );
        });
    }

    function renderSuggested(data) {

        const suggestedList =
            document.querySelector(".suggested-list");

        if (!suggestedList) return;

        suggestedList.innerHTML = "";

        (data.anunciantes_destacados || []).forEach(product => {
            suggestedList.appendChild(
                createProductItem(product)
            );
        });
    }

    /*
    |--------------------------------------------------------------------------
    | SEARCH
    |--------------------------------------------------------------------------
    */

    function renderSearchResults(data) {

        clearResults();
        openResults();

        renderRecents(data);

        const hasResults =
            data.products.length ||
            data.categories.length;

        if (!hasResults) {

            const li = document.createElement("li");
            li.className = "p-2 text-gray-500";
            li.textContent =
                "No se encontraron resultados";

            resultsList.appendChild(li);
            return;
        }

        data.categories.forEach(category => {
            resultsList.appendChild(
                createCategoryItem(category)
            );
        });

        data.products.forEach(product => {
            resultsList.appendChild(
                createProductItem(product)
            );
        });
    }

    function search(query) {

        fetch(`/search?query=${encodeURIComponent(query)}`)
            .then(r => r.json())
            .then(data => {
                renderSearchResults(data);
            });
    }

    /*
    |--------------------------------------------------------------------------
    | INIT
    |--------------------------------------------------------------------------
    */

    fetch("/search")
        .then(r => r.json())
        .then(data => {
            renderRecents(data);
            renderSuggested(data);
        });

    /*
    |--------------------------------------------------------------------------
    | INPUT EVENTS
    |--------------------------------------------------------------------------
    */

    searchBox.addEventListener("input", function () {

        const query = this.value.trim();

        clearButton.classList.toggle(
            "hidden",
            query.length === 0
        );

        if (query.length < 3) {
            closeResults();
            return;
        }

        clearTimeout(debounceTimer);

        debounceTimer = setTimeout(() => {
            search(query);
        }, 250);
    });

    /*
    |--------------------------------------------------------------------------
    | KEYBOARD NAVIGATION
    |--------------------------------------------------------------------------
    */

    searchBox.addEventListener("keydown", function (e) {

        const items = getItems();

        if (!items.length) return;

        if (e.key === "ArrowDown") {
            e.preventDefault();
            selectedIndex =
                selectedIndex < items.length - 1
                    ? selectedIndex + 1
                    : 0;

            highlightItem(selectedIndex);
        }

        if (e.key === "ArrowUp") {
            e.preventDefault();
            selectedIndex =
                selectedIndex > 0
                    ? selectedIndex - 1
                    : items.length - 1;

            highlightItem(selectedIndex);
        }

        if (e.key === "Enter") {
            e.preventDefault();

            if (selectedIndex >= 0 && items[selectedIndex]) {
                navigate(items[selectedIndex].href);
            }
        }

        if (e.key === "Escape") {
            closeResults();
        }
    });

    /*
    |--------------------------------------------------------------------------
    | CLOSE OUTSIDE
    |--------------------------------------------------------------------------
    */

    document.addEventListener("click", function (event) {

        if (
            !searchBox.contains(event.target) &&
            !resultsList.contains(event.target)
        ) {
            closeResults();
        }
    });

    /*
    |--------------------------------------------------------------------------
    | CLEAR
    |--------------------------------------------------------------------------
    */

    clearButton.addEventListener("click", function () {
        searchBox.value = "";
        clearButton.classList.add("hidden");
        clearResults();
        closeResults();
        searchBox.focus();
    });

});
</script>