// import Swiper JS
import Swiper from 'swiper';
// import Swiper styles
import 'swiper/css';
import { Grid } from 'swiper/modules';
import 'swiper/css/grid';

var article_gallery_images = new Swiper(".article_gallery_images", {
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
});
