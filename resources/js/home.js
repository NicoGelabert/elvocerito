import Swiper from 'swiper';
import 'swiper/css';
import { Grid } from 'swiper/modules';
import 'swiper/css/grid';

const swiperConfigs = {
  categories_content: {
    modules: [Grid],
    spaceBetween: 20,
    slidesPerView: 3,
    lazy: true,
    grid: { rows: 2, fill: 'row' },
    pagination: { el: ".swiper-pagination", clickable: true },
    breakpoints: {
      480: { slidesPerView: 4 },
      640: { slidesPerView: 6, grid: { rows: 1, fill: 'row' } },
      1024: { slidesPerView: 8, grid: { rows: 1, fill: 'row' } },
    },
  },
  servicios_destacados: {
    spaceBetween: 20,
    slidesPerView: 1.1,
    lazy: true,
    pagination: { el: ".swiper-pagination", clickable: true },
    breakpoints: {
      480: { slidesPerView: 1.5 },
      640: { slidesPerView: 2.1 },
      1024: { slidesPerView: 3.1 },
    },
  },
  ultimas_reviews: {
    spaceBetween: 20,
    slidesPerView: 1.1,
    lazy: true,
    pagination: { el: ".swiper-pagination", clickable: true },
    breakpoints: {
      480: { slidesPerView: 1.5 },
      640: { slidesPerView: 2.1 },
      1024: { slidesPerView: 3.1 },
    },
  },
  nuevos_servicios: {
    spaceBetween: 20,
    slidesPerView: 1.1,
    lazy: true,
    pagination: { el: ".swiper-pagination", clickable: true },
    breakpoints: {
      480: { slidesPerView: 1.5 },
      640: { slidesPerView: 2.1 },
      1024: { slidesPerView: 3.1 },
    },
  },
  news: {
    spaceBetween: 20,
    slidesPerView: 1.1,
    lazy: true,
    pagination: { el: ".swiper-pagination", clickable: true },
    breakpoints: {
      480: { slidesPerView: 1.5 },
      640: { slidesPerView: 2.1 },
      1024: { slidesPerView: 3.1 },
    },
  },
};

export function init() {
  const observer = new IntersectionObserver((entries) => {
    entries.forEach((entry) => {
      if (entry.isIntersecting) {
        const el = entry.target;
        const key = el.dataset.swiper;
        const config = swiperConfigs[key];

        if (config) {
          new Swiper(el, config);
          observer.unobserve(el); // No volver a inicializar
        }
      }
    });
  }, ); // Empieza a cargar 200px antes de entrar al viewport

  // Observar todos los contenedores con data-swiper
  document.querySelectorAll('[data-swiper]').forEach((el) => {
    observer.observe(el);
  });
}