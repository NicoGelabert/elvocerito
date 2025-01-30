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
        padding     : '3rem',
        gap         : '1rem',
        pagination  : true,
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
            arrows    : 'splide__arrows_custom splide__arrows_custom_news',
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
  