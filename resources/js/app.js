import './bootstrap';
// import { createApp } from 'vue';
// import HelloWorld from './components/ProductList.vue';

// const app = createApp(HelloWorld);  
// app.mount('#app');


import { createApp } from 'vue';
import App from './App.vue';
import router from './router/index.js';

import { createRouter, createWebHistory } from 'vue-router';
// import Home from '../components/Home.vue';
// import Deshboard from './components/admin/Deshboard.vue';
// import AdminLayout from './components/admin/Layouts/AdminLayout.vue';
// import Categories from './components/admin/category/Categories.vue';
// import Login from './components/admin/Login.vue';
// import SubCategories from './components/admin/category/SubCategories.vue';
// import Products from './components/admin/product/Products.vue';
// import Brands from './components/admin/product/Brands.vue';
// import Banners from './components/admin/coupon/Banners.vue';
// import Coupons from './components/admin/coupon/Coupons.vue';
// import Orders from './components/admin/orders/Orders.vue';
// import Users from './components/admin/report/Users.vue';
// import FeedBack from './components/admin/report/FeedBack.vue';
// import 'font-awesome/css/font-awesome.min.css';

// const routes = [
//     { path: '/', component: Deshboard },
//     { path: '/deshboard', component: Deshboard },
//     { path: '/categories', component: Categories },
//     { path: '/admins/login', component: Login },
//     { path: '/subcategories', component: SubCategories },
//     { path: '/products', component: Products },
//     { path: '/brands', component: Brands },
//     { path: '/banners', component: Banners },
//     { path: '/coupons', component: Coupons },
//     { path: '/orders', component: Orders },
//     { path: '/users', component: Users },
//     { path: '/feedbacks', component: FeedBack },

// ]

// const router = createRouter({
//     history: createWebHistory(),
//     routes,
// })

const app = createApp(App).use(router).mount('#app');
