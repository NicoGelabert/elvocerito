import Splide from '@splidejs/splide';
import { Grid } from '@splidejs/splide-extension-grid';

var articleGalleryElement = document.querySelector('.article_gallery_images');
if (articleGalleryElement) {
    var articleGallery = new Splide(articleGalleryElement, {
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

articleGallery.mount({ Grid });
};
