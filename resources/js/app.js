import './bootstrap';

import { createApp } from 'vue/dist/vue.esm-bundler';
import Alpine from 'alpinejs';
import collapse from '@alpinejs/collapse'
import {get, post} from "./http.js";
import 'flowbite';
import Splide from '@splidejs/splide';
import ProductList from './components/products/ProductList.vue';

const productIndex = createApp({});
productIndex.component('product-list', ProductList);
productIndex.mount('#product-index');
Alpine.plugin(collapse)

window.Alpine = Alpine;

document.addEventListener("alpine:init", async () => {

  Alpine.data("toast", () => ({
    visible: false,
    delay: 5000,
    percent: 0,
    interval: null,
    timeout: null,
    message: null,
    close() {
      this.visible = false;
      clearInterval(this.interval);
    },
    show(message) {
      this.visible = true;
      this.message = message;

      if (this.interval) {
        clearInterval(this.interval);
        this.interval = null;
      }
      if (this.timeout) {
        clearTimeout(this.timeout);
        this.timeout = null;
      }

      this.timeout = setTimeout(() => {
        this.visible = false;
        this.timeout = null;
      }, this.delay);
      const startDate = Date.now();
      const futureDate = Date.now() + this.delay;
      this.interval = setInterval(() => {
        const date = Date.now();
        this.percent = ((date - startDate) * 100) / (futureDate - startDate);
        if (this.percent >= 100) {
          clearInterval(this.interval);
          this.interval = null;
        }
      }, 30);
    },
  }));

  Alpine.data("productItem", (product) => {
    return {
      product,
      addToCart(quantity = 1) {
        post(this.product.addToCartUrl, {quantity})
          .then(result => {
            this.$dispatch('cart-change', {count: result.count})
            this.$dispatch("notify", {
              message: "The item was added into the cart",
            });
          })
          .catch(response => {
            console.log(response);
          })
      },
      removeItemFromCart() {
        post(this.product.removeUrl)
          .then(result => {
            this.$dispatch("notify", {
              message: "The item was removed from cart",
            });
            this.$dispatch('cart-change', {count: result.count})
            this.cartItems = this.cartItems.filter(p => p.id !== product.id)
          })
      },
      changeQuantity() {
        post(this.product.updateQuantityUrl, {quantity: product.quantity})
          .then(result => {
            this.$dispatch('cart-change', {count: result.count})
            this.$dispatch("notify", {
              message: "The item quantity was updated",
            });
          })
      },
    };
  });
  
  Alpine.data('lightbox', () => ({
    isOpen: false,
    imageUrl: '',
    openLightbox(url) {
        this.imageUrl = url;
        this.isOpen = true;
    }
  }))
  
});

Alpine.start();

// dark mode
const toggleThemeButtons = document.querySelectorAll('.toggle-theme');
function toggleTheme() {
  document.documentElement.classList.toggle('dark');
  toggleThemeButtons.forEach(button => {
    button.classList.toggle('dark');
  });

  if (document.documentElement.classList.contains('dark')) {
    localStorage.setItem('theme', 'dark');
  } else {
    localStorage.setItem('theme', 'light');
  }

}
toggleThemeButtons.forEach(button => {
  button.addEventListener('click', toggleTheme);
});

document.addEventListener('DOMContentLoaded', () => {
  const savedTheme = localStorage.getItem('theme');

  if (savedTheme === 'dark') {
    document.documentElement.classList.add('dark');
    toggleThemeButtons.forEach(button => {
      button.classList.add('dark');
    });
  }
});
// dark mode

// SPLIDE
document.addEventListener( 'DOMContentLoaded', function () {
  // Home Hero Banner
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
  // Fin Home Hero Banner
  // Últimos anunciantes
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
  // Fin Últimos anunciantes
  // News
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
    news.mount();
  }
  // Fin News
});