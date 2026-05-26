import Swiper from 'swiper';
import 'swiper/css';
import { Grid } from 'swiper/modules';
import 'swiper/css/grid';

export function init() {
  new Swiper(".product_gallery_images", {
    modules: [Grid],
    spaceBetween: 20,
    slidesPerView: 3,
    grid: { rows: 2, fill: 'row' },
    slidesOffsetAfter: 0,
    pagination: { el: ".swiper-pagination", clickable: true },
  });
  const tabButtons = document.querySelectorAll('[role="tab"]');
    const tabContents = document.querySelectorAll('[role="tabpanel"]');

    if (tabButtons.length === 0 || tabContents.length === 0) return;

    tabButtons.forEach((button) => {
        button.addEventListener("click", () => {
            const targetId = button.getAttribute("data-tabs-target");

            // Deactivate all tabs
            tabButtons.forEach((btn) => {
                btn.setAttribute("aria-selected", "false");
                btn.classList.remove(
                    "text-primary", "border-primary",
                    "hover:text-primary", "hover:border-primary"
                );
                btn.classList.add(
                    "text-gray-500", "border-transparent",
                    "hover:text-gray-600", "hover:border-gray-300"
                );
            });

            // Hide all contents
            tabContents.forEach((content) => {
                content.classList.add("hidden");
            });

            // Activate clicked tab
            button.setAttribute("aria-selected", "true");
            button.classList.remove(
                "text-gray-500", "border-transparent",
                "hover:text-gray-600", "hover:border-gray-300"
            );
            button.classList.add(
                "text-primary", "border-primary",
                "hover:text-primary", "hover:border-primary"
            );

            // Show corresponding tab content
            if (targetId) {
                const targetContent = document.querySelector(targetId);
                if (targetContent) {
                    targetContent.classList.remove("hidden");
                }
            }
        });
    });

    // Click the first tab by default
    tabButtons[0].click();
}