import Swiper from 'swiper';
import 'swiper/css';
import { Grid } from 'swiper/modules';
import 'swiper/css/grid';

export function init() {
  new Swiper(".article_gallery_images", {
    modules: [Grid],
    spaceBetween: 20,
    slidesPerView: 3,
    grid: { rows: 2, fill: 'row' },
    slidesOffsetAfter: 0,
    pagination: { el: ".swiper-pagination", clickable: true },
  });
}