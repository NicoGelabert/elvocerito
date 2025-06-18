import 'flowbite';
import './bootstrap';
import { Tabs } from 'flowbite';
import Alpine from 'alpinejs';
import collapse from '@alpinejs/collapse';
import { get, post } from "./http.js";

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

  Alpine.data('verificarEstado', (horarios) => ({
    estado: 'Cargando...',
    
    init() {
        this.comprobarEstado();
        setInterval(() => this.comprobarEstado(), 60000); // Actualiza cada minuto
    },
    
    comprobarEstado() {
        let diasSemana = ["domingo", "lunes", "martes", "miércoles", "jueves", "viernes", "sábado"];
        let ahora = new Date();
        let diaActual = diasSemana[ahora.getDay()];
        let horaActual = ahora.getHours() * 60 + ahora.getMinutes();

        // Filtrar el horario correspondiente al día actual
        let horarioHoy = horarios.find(h => h.dia.toLowerCase() === diaActual);

        if (horarioHoy) {
            let aperturaMin = this.convertirAHorasMinutos(horarioHoy.apertura);
            let cierreMin = this.convertirAHorasMinutos(horarioHoy.cierre);

            if (aperturaMin <= cierreMin) {
                // Horario normal (ej: 08:00 - 20:00)
                this.estado = (horaActual >= aperturaMin && horaActual < cierreMin) ? 'Disponible' : 'No Disponible';
            } else {
                // Cruza la medianoche (ej: 22:00 - 03:00)
                this.estado = (horaActual >= aperturaMin || horaActual < cierreMin) ? 'Disponible' : 'No Disponible';
            }
        } else {
            this.estado = 'No Disponible'; // Si no hay horario para el día, cerramos
        }
    },
    
    convertirAHorasMinutos(hora) {
        let [h, m] = hora.split(':').map(Number);
        return h * 60 + m;
    }
  }));

  Alpine.data('verificarHorario', (dia, apertura, cierre) => ({
    estado: 'Cargando...',
    esHoy: false,  // Variable para determinar si es hoy

    init() {
        this.comprobarEstado();
        setInterval(() => this.comprobarEstado(), 60000); // Actualiza cada minuto
    },

    comprobarEstado() {
        let diasSemana = ["domingo", "lunes", "martes", "miércoles", "jueves", "viernes", "sábado"];
        let ahora = new Date();
        let diaActual = diasSemana[ahora.getDay()];
        let horaActual = ahora.getHours() * 60 + ahora.getMinutes();
        let aperturaMin = this.convertirAHorasMinutos(apertura);
        let cierreMin = this.convertirAHorasMinutos(cierre);

        // Verificar si es el día actual
        this.esHoy = diaActual.toLowerCase() === dia.toLowerCase();  // Verifica si es hoy

        if (this.esHoy) {
            if (aperturaMin <= cierreMin) {
                // Verificar si la hora actual está dentro del horario de apertura y cierre
                this.estado = (horaActual >= aperturaMin && horaActual < cierreMin) ? 'Disponible' : 'No Disponible';
            } else {
                // Horario que cruza medianoche
                this.estado = (horaActual >= aperturaMin || horaActual < cierreMin) ? 'Disponible' : 'No Disponible';
            }
        } else {
            this.estado = 'No Disponible'; // Si no es hoy, marcarlo como cerrado
        }
    },

    convertirAHorasMinutos(hora) {
        let [h, m] = hora.split(':').map(Number);
        return h * 60 + m;
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
  } else if (page === 'news.view') {
    import('./article-view.js');
  }

});

let prevScrollpos = window.scrollY;
let scrollThreshold = 5;
window.onscroll = function () {
  var currentScrollPos = window.scrollY;
  var scrollDifference = Math.abs(prevScrollpos - currentScrollPos);
  var navbarHeight = navbar.offsetHeight; // Altura del navbar
  var searchTriggerPoint = 300;
  var productMenu = document.querySelector('.product_menu');
  var page = document.body.dataset.page;  

    // 📌 Lógica de Navbar (Se ejecuta siempre)
  if (scrollDifference >= scrollThreshold) {
    if (prevScrollpos > currentScrollPos) {
      navbar.style.top = "0"; // Navbar vuelve a aparecer
    } else {
      navbar.style.top = `-${navbarHeight}px`;  // Navbar desaparece
    }
  }
    
  prevScrollpos = currentScrollPos;
  
  // 📌 Lógica de productMenu (SOLO SI ESTAMOS EN product.view)
  if (page === 'product.view' && productMenu) {
    if (currentScrollPos >= searchTriggerPoint) {
      if (navbar.style.top === "0px") {
        productMenu.classList.remove("opacity-0", "-translate-y-full");
        productMenu.classList.add("opacity-100", "translate-y-0", "transition-all", "duration-300");
        productMenu.style.top = `${navbarHeight}px`;
      } else {
        productMenu.classList.remove("opacity-0", "-translate-y-full");
        productMenu.classList.add("opacity-100", "translate-y-0", "transition-all", "duration-300");
        productMenu.style.top = "0px";
      }
    } else {
      // Asegurar que la transición se aplique correctamente
      productMenu.classList.remove("translate-y-0", "opacity-100");
      productMenu.classList.add("-translate-y-full");
      // Opcional: Resetear "top" después de la animación
      setTimeout(() => {
        productMenu.style.top = "";
        productMenu.classList.add("opacity-0");
      }, 300);
    }
  }
  // 📌 Lógica para mover product_header en desktop SOLO en product.view
  function moveHeader(pageName, selector) {
    if (page === pageName && window.innerWidth >= 1024) {
      const header = document.querySelector(selector);
      if (header) {
        if (navbar.style.top === "0px") {
          header.style.top = "5rem";
        } else {
          header.style.top = "2rem";
        }
      }
    }
  }
  moveHeader('product.view', '.product_header');
  moveHeader('news.view', '.article_header');  
};

// INICIO TABS DE FLOWBITE EN PRODUCT.VIEW
const tabEl = document.getElementById('custom-tabs');

if (tabEl) {
    new Tabs(tabEl, {
        activeClasses: 'text-primary border-primary',
        inactiveClasses: 'text-gray-500 border-transparent hover:text-primary hover:border-primary',
    });
}
// FIN TABS DE FLOWBITE EN PRODUCT.VIEW