import './bootstrap';
import Alpine from 'alpinejs';
import collapse from '@alpinejs/collapse';
import { get, post } from "./http.js";
import 'flowbite';

Alpine.plugin(collapse);

document.addEventListener("alpine:init", () => {
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
  }));
});

window.Alpine = Alpine;
Alpine.start();

// 🚀 Cargar scripts según la página
document.addEventListener("DOMContentLoaded", () => {
  
  // 🚀 Progreso de carga (porcentaje)
  let percentage = 0;
  const progressBar = document.getElementById('progress-bar');
  const interval = setInterval(function() {
    if (percentage < 100) {
      percentage += 1;
      document.getElementById('loader-percentage').innerText = percentage + '%';
      progressBar.style.width = percentage + '%';
    } else {
      clearInterval(interval);
      document.getElementById('loader-wrapper').style.display = 'none';
      const content = document.getElementById('body-content');
      content.style.display = 'block';
      setTimeout(function() {
        content.classList.add('fade-in');
      }, 10);
    }
  })
  
  // Movimiento del header
  // Movimiento del header
let prevScrollpos = window.scrollY;
let scrollThreshold = 5;
window.onscroll = function () {
    var currentScrollPos = window.scrollY;
    var scrollDifference = Math.abs(prevScrollpos - currentScrollPos);
    var navbarHeight = navbar.offsetHeight; // Altura del navbar
    var searchBar = document.querySelector(".search_bar");
    var searchTriggerPoint = 325; // Punto donde el search se fija
  
    // 📌 Lógica de Navbar
    if (scrollDifference >= scrollThreshold) {
        if (prevScrollpos > currentScrollPos) {
            navbar.style.top = "0"; // Navbar vuelve a aparecer
        } else {
            navbar.style.top = `-${navbarHeight}px`; // Navbar desaparece
        }
    }
    prevScrollpos = currentScrollPos;
  
    // 📌 Lógica para fijar el Search Bar después de 325px de scroll
    if (currentScrollPos >= searchTriggerPoint) {
        // Si el navbar está visible (top = 0), colocamos el search bar justo debajo
        if (navbar.style.top === "0px") {
            searchBar.classList.add("fixed");
            searchBar.style.top = `${navbarHeight - 1}px`; // Posicionamos debajo del navbar
        } else {
            searchBar.classList.add("fixed");
            searchBar.style.top = `0px`; // Si el navbar está oculto, el search bar se coloca en la parte superior
        }
    } else {
        // Si el scroll es menor que 325px, el search bar regresa a su posición original
        searchBar.classList.remove("fixed");
        searchBar.style.top = ""; // Vuelve a su posición normal
    }
  
    // 📌 Añadir o quitar clase cuando el scroll está cerca del top
    if (currentScrollPos <= 5) {
        navbar.classList.remove("scrolled-bottom");
    } else {
        navbar.classList.add("scrolled-bottom");
    }

    // 📌 Lógica de productMenu (SOLO SI ESTAMOS EN product.view)
    // if (productMenu && productContact) {
    //     var rect = productContact.getBoundingClientRect();
    //     var navbarTop = parseInt(navbar.style.top, 10) || 0;

    //     if (rect.top <= 0) {
    //         // Mostrar productMenu con animación
    //         productMenu.classList.remove("opacity-0", "-translate-y-full");
    //         productMenu.classList.add("flex", "opacity-100", "translate-y-0", "transition-all", "duration-300");

    //         // Asegurarse de que productMenu se mueva abajo con el navbar
    //         productMenu.style.top = navbarTop >= 0 ? `${navbarHeight}px` : "0px";
    //     } else {
    //         // Ocultar productMenu con animación
    //         productMenu.classList.remove("flex", "opacity-100", "translate-y-0");
    //         productMenu.classList.add("-translate-y-full", "transition-transform", "duration-300");

    //         // Resetear top para evitar posiciones incorrectas
    //         productMenu.style.top = "";
    //     }
    // }
};


  // Captura de nombre de la página
  const page = document.body.dataset.page;  
  // carga de archivos js por nombre de página
  if (page === 'product.urgencies' || page === 'categories.view' || page === 'categories.view.subcategory') {
    import('./catalog.js');
  } else if (page === 'welcome') {
    import('./home.js');
  } else if (page === 'product.view') {
    import('./product-view.js');
  } else if (page === 'categories.index') {
    import('./categories-index.js');
  }
  
});
