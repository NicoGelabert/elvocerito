import Splide from '@splidejs/splide';

var productGalleryElement = document.querySelector('.product_gallery_images');
if (productGalleryElement) {
    var productGallery = new Splide(productGalleryElement, {
        type        : 'loop',
        arrows      : false,
});

productGallery.mount();
};