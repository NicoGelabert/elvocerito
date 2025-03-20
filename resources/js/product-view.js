import Splide from '@splidejs/splide';
import { Grid } from '@splidejs/splide-extension-grid';

var productGalleryElement = document.querySelector('.product_gallery_images');
if (productGalleryElement) {
    var productGallery = new Splide(productGalleryElement, {
        arrows      : true,
        grid       : {
            dimensions: [ [ 2, 3 ] ],
            gap: {
              row: '1rem',
              col: '1rem',
            },
        },
        pagination  : false,
        perPage     : 1,
        perMove     : 1,
        type        : 'loop',
});

productGallery.mount({ Grid });
};
