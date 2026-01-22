import Splide from '@splidejs/splide';
import { Grid } from '@splidejs/splide-extension-grid';

// SPLIDE
// // Home Hero Banner
var homeHeroBannerElement = document.querySelector('.home-hero-banner');
if (homeHeroBannerElement) {
    var homeHeroBanner = new Splide(homeHeroBannerElement, {
        type        : 'loop',
        rewind      : true,
        autoplay    : false,
        arrows      : false,
        pagination  : false,
        interval    : 5000,
        gap     : '10rem',
        breakpoints: {
          480: {
            gap     : '5rem',
        }
    },
});

homeHeroBanner.mount();
};
// //Fin Home Hero Banner

// Categories
var categoriesElement = document.querySelector('.categories');
if (categoriesElement) {
    var categories = new Splide(categoriesElement, {
        autoplay    : false,
        gap         : '1rem',
        pagination  : false,
        padding     : 0,
        perMove     : 8,
        perPage     : 8,
        breakpoints: {
            768: {
                perPage     : 6,
                perMove     : 6,
            },
            480: {
                height      : '12rem',
                perPage     : 1,
                perMove     : 1,
                grid       : {
                    dimensions: [ [ 2, 3 ] ],
                    gap: {
                      row: '0.5rem',
                      col: '0.5rem',
                    },
                },
                
            }
        },
    })
};
categories.mount({ Grid });
// Fin Categories
// Productos Vistos recientemente
var productosRecientementeVistosElement = document.querySelector('#productos_recientemente_vistos');
if (productosRecientementeVistosElement) {
    var productosRecientementeVistos = new Splide(productosRecientementeVistosElement, {
        arrows      : false,
        autoplay    : false,
        gap         : '1rem',
        interval    : 4000,
        pagination  : false,
        perPage     : 3,
        type        : 'slide',
        breakpoints: {
            1024: {
                perPage     : 2,
            },
            // 768: {
            //     perPage     : 5,
            // },
            480: {
                perPage     : 1,
                gap         : '1rem',
                padding     : '1rem',
            }
        },
    })
    productosRecientementeVistos.mount();
};
// Fin Productos Vistos recientemente

// Categorías Vistas recientemente
var categoriasRecientementeVistasElement = document.querySelector('#categorias_recientemente_vistas');
if (categoriasRecientementeVistasElement) {
    var categoriasRecientementeVistas = new Splide(categoriasRecientementeVistasElement, {
        arrows      : false,
        autoplay    : false,
        gap         : '1rem',
        interval    : 4000,
        pagination  : false,
        perPage     : 4,
        type        : 'slide',
        breakpoints: {
            1024: {
                perPage     : 3,
            },
            // 768: {
            //     perPage     : 5,
            // },
            480: {
                perPage     : 2,
                gap         : '1rem',
                padding     : '1rem',
            }
        },
    })
    categoriasRecientementeVistas.mount();
};
// Fin Categorías Vistas recientemente
// Últimos anunciantes
var ultimosAnuncinatesElement = document.querySelector('#ultimos_anunciantes');
if (ultimosAnuncinatesElement) {
    var ultimosAnuncinates = new Splide(ultimosAnuncinatesElement, {
        arrows      : false,
        autoplay    : false,
        gap         : '1rem',
        interval    : 4000,
        pagination  : false,
        perPage     : 3,
        type        : 'loop',
        breakpoints: {
            1024: {
                perPage     : 2,
            },
            // 768: {
            //     perPage     : 5,
            // },
            480: {
                perPage     : 1,
                gap         : '1rem',
                padding     : '1rem',
            }
        },
    })
};

ultimosAnuncinates.mount();
// Fin Últimos anunciantes
// Últimas reviews
var ultimasReviewsElement = document.querySelector('#ultimas_reviews');
if (ultimasReviewsElement) {
    var ultimasReviews = new Splide(ultimasReviewsElement, {
        arrows      : false,
        autoplay    : false,
        gap         : '1rem',
        interval    : 4000,
        pagination  : false,
        perPage     : 3,
        type        : 'loop',
        breakpoints: {
            1024: {
                perPage     : 2,
            },
            // 768: {
            //     perPage     : 5,
            // },
            480: {
                perPage     : 1,
                gap         : '1rem',
                padding     : '1rem',
            }
        },
    })
};

ultimasReviews.mount();
// Fin Últimas reviews
// Fin Splide
  