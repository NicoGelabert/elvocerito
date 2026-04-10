// import Swiper JS
import Swiper from 'swiper';
// import Swiper styles
import 'swiper/css';
import { Grid } from 'swiper/modules';
import 'swiper/css/grid';

// SWIPER
// Categories
var categories_content = new Swiper(".categories_content", {
    modules: [Grid],
    spaceBetween: 20,
    slidesPerView: 3,
    grid: {
        rows: 2,
        fill: 'row',
      },
    slidesOffsetAfter: 0,
    pagination: {
        el: ".swiper-pagination",
        clickable: true,
    },
    breakpoints: {
        480: {
        slidesPerView: 4,    
        },
        640: {
        slidesPerView: 6,
            grid: {
                rows: 1,
                fill: 'row',
            },
        },
        1024: {
            slidesPerView: 7,
            grid: {
                rows: 1,
                fill: 'row',
            },
        },
    },
});
// Fin Categories

// Servicios destacados
var servicios_destacados = new Swiper(".servicios_destacados", {
    spaceBetween: 20,
    slidesPerView: 1.1,
    slidesOffsetAfter: 0,
    pagination: {
        el: ".swiper-pagination",
        clickable: true,
    },
    breakpoints: {
        480: {
        slidesPerView: 1.5,    
        },
        640: {
        slidesPerView: 2.1,
        },
        1024: {
        slidesPerView: 3.1,
        },
    },
});
// Fin servicios destacados
// Últimas reviews
var ultimas_reviews = new Swiper(".ultimas_reviews", {
    spaceBetween: 20,
    slidesPerView: 1.1,
    slidesOffsetAfter: 0,
    pagination: {
        el: ".swiper-pagination",
        clickable: true,
    },
    breakpoints: {
        480: {
        slidesPerView: 1.5,    
        },
        640: {
        slidesPerView: 2.1,
        },
        1024: {
        slidesPerView: 3.1,
        },
    },
});
// Fin Últimas reviews
// Nuevos Servicios
var nuevos_servicios = new Swiper(".nuevos_servicios", {
    spaceBetween: 20,
    slidesPerView: 1.1,
    slidesOffsetAfter: 0,
    pagination: {
        el: ".swiper-pagination",
        clickable: true,
    },
    breakpoints: {
        480: {
        slidesPerView: 1.5,    
        },
        640: {
        slidesPerView: 2.1,
        },
        1024: {
        slidesPerView: 3.1,
        },
    },
});
// Fin Nuevos Servicios
// Categorías Vistas recientemente
var categorias_vistas = new Swiper(".categorias_vistas", {
    spaceBetween: 20,
    slidesPerView: 1.1,
    slidesOffsetAfter: 0,
    pagination: {
        el: ".swiper-pagination",
        clickable: true,
    },
    breakpoints: {
        480: {
        slidesPerView: 1.5,    
        },
        640: {
        slidesPerView: 2.1,
        },
        1024: {
        slidesPerView: 3.1,
        },
    },
});
// Fin Categorías Vistas recientemente
// Productos Vistos recientemente
var servicios_vistos = new Swiper(".servicios_vistos", {
    spaceBetween: 20,
    slidesPerView: 1.1,
    slidesOffsetAfter: 0,
    pagination: {
        el: ".swiper-pagination",
        clickable: true,
    },
    breakpoints: {
        480: {
        slidesPerView: 1.5,    
        },
        640: {
        slidesPerView: 2.1,
        },
        1024: {
        slidesPerView: 3.1,
        },
    },
});
// Fin Productos Vistos recientemente
// Servicios destacados
var news = new Swiper(".news", {
    spaceBetween: 20,
    slidesPerView: 1.1,
    slidesOffsetAfter: 0,
    pagination: {
        el: ".swiper-pagination",
        clickable: true,
    },
    breakpoints: {
        480: {
        slidesPerView: 1.5,    
        },
        640: {
        slidesPerView: 2.1,
        },
        1024: {
        slidesPerView: 3.1,
        },
    },
});
// Fin servicios destacados
// Fin SWIPER
  