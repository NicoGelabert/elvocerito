import Swiper from 'swiper';
import 'swiper/css';
import { Grid } from 'swiper/modules';
import 'swiper/css/grid';
import { createApp } from 'vue/dist/vue.esm-bundler';
import ReviewForm from './components/reviews/ReviewForm.vue';
import ReviewList from './components/reviews/ReviewList.vue';
import RatingAverage from './components/reviews/RatingAverage.vue';

let productViewAppInstance = null;

export function init() {
    // Vue reviews — destruir instancia anterior si existe
    const el = document.getElementById('product-view-app');
    if (el) {
        if (productViewAppInstance) {
            productViewAppInstance.unmount();
            productViewAppInstance = null;
        }

        // Guardar el contenido original
        const originalContent = el.innerHTML;
        el.innerHTML = `<div id="product-view-app-inner">${originalContent}</div>`;

        productViewAppInstance = createApp({});
        productViewAppInstance.component('review-form', ReviewForm);
        productViewAppInstance.component('review-list', ReviewList);
        productViewAppInstance.mount('#product-view-app-inner');
    }

    document.querySelectorAll('.product-rating-average').forEach(el => {
        const productId = el.dataset.productId;
        createApp({
            data() { return { productId }; },
            components: { RatingAverage },
            template: `<rating-average :product-id="productId"/>`
        }).mount(el);
    });

    // Swiper galería
    new Swiper(".product_gallery_images", {
        modules: [Grid],
        spaceBetween: 20,
        slidesPerView: 3,
        grid: { rows: 2, fill: 'row' },
        slidesOffsetAfter: 0,
        pagination: { el: ".swiper-pagination", clickable: true },
    });

    // Tabs
    const tabButtons = document.querySelectorAll('[role="tab"]');
    const tabContents = document.querySelectorAll('[role="tabpanel"]');
    if (tabButtons.length === 0 || tabContents.length === 0) return;

    tabButtons.forEach((button) => {
        button.addEventListener("click", () => {
        const targetId = button.getAttribute("data-tabs-target");
        tabButtons.forEach((btn) => {
            btn.setAttribute("aria-selected", "false");
            btn.classList.remove("text-primary", "border-primary", "hover:text-primary", "hover:border-primary");
            btn.classList.add("text-gray-500", "border-transparent", "hover:text-gray-600", "hover:border-gray-300");
        });
        tabContents.forEach((content) => content.classList.add("hidden"));
        button.setAttribute("aria-selected", "true");
        button.classList.remove("text-gray-500", "border-transparent", "hover:text-gray-600", "hover:border-gray-300");
        button.classList.add("text-primary", "border-primary", "hover:text-primary", "hover:border-primary");
        if (targetId) {
            document.querySelector(targetId)?.classList.remove("hidden");
        }
        });
    });

    tabButtons[0]?.click();
}