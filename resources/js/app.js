import './bootstrap';
// import { createApp } from 'vue';
// import HelloWorld from './components/ProductList.vue';

// const app = createApp(HelloWorld);  
// app.mount('#app');


import { createApp } from 'vue';
import { createPinia } from 'pinia';
import App from './App.vue';
import router from './router/index.js';
axios.defaults.withCredentials = true;


const pinia = createPinia();
import { createRouter, createWebHistory } from 'vue-router';


const app = createApp(App).use(pinia).use(router).mount('#app');
