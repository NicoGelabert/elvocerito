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
  const page = document.body.dataset.page;
  
  if (page === 'products.index') {
    import('./catalog.js');
  } else if (page === 'welcome') {
    import('./home.js');
  }
});
