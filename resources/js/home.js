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
        perMove     : 8,
        perPage     : 8,
    })
};
categories.mount();
// Fin Categories
// // Últimos anunciantes
var ultimosAnuncinatesElement = document.querySelector('#ultimos_anunciantes');
if (ultimosAnuncinatesElement) {
    var ultimosAnuncinates = new Splide(ultimosAnuncinatesElement, {
        arrows      : false,
        autoplay    : false,
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
        gap         : '1rem',
        interval    : 4000,
        padding     : '2rem',
        pagination  : false,
        perPage     : 6,
        type        : 'loop',
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
  