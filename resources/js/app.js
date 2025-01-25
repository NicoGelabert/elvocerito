import './bootstrap';

import { createApp } from 'vue/dist/vue.esm-bundler';
import Alpine from 'alpinejs';
import collapse from '@alpinejs/collapse'
import {get, post} from "./http.js";
import 'flowbite';
import Splide from '@splidejs/splide';
import ProductList from './components/products/ProductList.vue';

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
      type        : 'slide',
      rewind      : true,
      autoplay    : true,
      arrows      : false,
      padding     : '3rem',
      gap         : '1rem',
      pagination  : true,
      interval    : 5000,
    });
    homeHeroBanner.mount();
  };
});