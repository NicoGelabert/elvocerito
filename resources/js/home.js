import Splide from '@splidejs/splide';

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
        breakpoints: {
          480: {
            padding : '1.5rem',
            gap     : '0.75rem',
        }
    },
});

homeHeroBanner.mount();
};
// //Fin Home Hero Banner

// Categories
var categoriesElement = document.querySelector('#categories');
if (categoriesElement) {
    var categories = new Splide(categoriesElement, {
        autoplay    : false,
        breakpoints: {
            1280: {
                perPage     : 10,
                perMove     : 10,
            },
            1024: {
                perPage     : 8,
                perMove     : 8,
            },
            768: {
                perPage     : 6,
                perMove     : 6,
            },
            480: {
                perPage     : 3,
                perMove     : 3,
            }
        },
        classes: {
            arrows    : 'splide__arrows_custom',
        },
        gap         : '1rem',
        pagination  : false,
        padding     : 0,
        perMove     : 12,
        perPage     : 12,
    })
};
categories.mount();
// Fin Categories
// // Últimos anunciantes
var ultimosAnuncinatesElement = document.querySelector('#ultimos_anunciantes');
if (ultimosAnuncinatesElement) {
    var ultimosAnuncinates = new Splide(ultimosAnuncinatesElement, {
        type        : 'loop',
        perPage     : 5,
        arrows      : false,
        gap         : '1rem',
        padding     : '2rem',
        autoplay    : true,
        interval    : 4000,
        breakpoints: {
            1024: {
                perPage     : 4,
            },
            768: {
                perPage     : 3,
            },
            480: {
                perPage     : 2,
                gap         : '0.5rem',
                padding     : '1rem',          
            }
        },
    })
};

ultimosAnuncinates.mount();
// // Fin Últimos anunciantes
// // News
var newsElement = document.querySelector('.news');
if (newsElement) {
    var news = new Splide(newsElement, {
        classes: {
            pagination: 'splide__pagination_custom',
        },
        gap       : '1.5rem',
        pagination: true,
        rewind    : true,
        type      : 'loop',
    });
}
news.mount();
// // Fin News
// Fin Splide
  