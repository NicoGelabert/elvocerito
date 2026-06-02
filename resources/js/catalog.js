import { createApp } from 'vue/dist/vue.esm-bundler';
import ProductList from './components/products/ProductList.vue';
import ContactModal from './components/ContactModal.vue'

export function init() {
  const productIndex = createApp({});
  productIndex.component('product-list', ProductList);
  productIndex.component('contact-modal', ContactModal);
  productIndex.mount('.product-index');
}