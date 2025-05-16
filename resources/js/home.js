import Splide from '@splidejs/splide';
import { Grid } from '@splidejs/splide-extension-grid';

// SPLIDE
// // Home Hero Banner
var homeHeroBannerElement = document.querySelector('.home-hero-banner');
if (homeHeroBannerElement) {
    var homeHeroBanner = new Splide(homeHeroBannerElement, {
        type        : 'loop',
        rewind      : true,
        autoplay    : true,
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
// Vistos recientemente
var recientementeVistosElement = document.querySelector('#recientemente_vistos');
if (recientementeVistosElement) {
    var recientementeVistos = new Splide(recientementeVistosElement, {
        arrows      : false,
        autoplay    : false,
        gap         : '2rem',
        interval    : 4000,
        padding     : '2rem',
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
                padding     : '3rem',
            }
        },
    })
    recientementeVistos.mount();
};
// Fin Vistos recientemente
// Últimos anunciantes
var ultimosAnuncinatesElement = document.querySelector('#ultimos_anunciantes');
if (ultimosAnuncinatesElement) {
    var ultimosAnuncinates = new Splide(ultimosAnuncinatesElement, {
        arrows      : false,
        autoplay    : false,
        gap         : '2rem',
        interval    : 4000,
        padding     : '2rem',
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
                padding     : '3rem',
            }
        },
    })
};

ultimosAnuncinates.mount();
// Fin Últimos anunciantes
// Fin Splide
  