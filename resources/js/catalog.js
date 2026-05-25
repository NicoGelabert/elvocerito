import { createApp } from 'vue/dist/vue.esm-bundler';
import ProductList from './components/products/ProductList.vue';

export function init() {
  const productIndex = createApp({});
  productIndex.component('product-list', ProductList);
  productIndex.mount('.product-index');
}