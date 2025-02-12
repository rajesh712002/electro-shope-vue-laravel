import { createRouter, createWebHistory } from 'vue-router';
import Home from '../components/Home.vue';
import Deshboard from '../components/admin/Deshboard.vue';
import AdminLayout from '../components/admin/Layouts/AdminLayout.vue';
import Login from '../components/admin/Login.vue';

import Categories from '../components/admin/category/Categories.vue';
import CategoryCreate from '../components/admin/category/CategoryCreate.vue';
import CategoryUpdate from '../components/admin/category/CategoryUpdate.vue';

import SubCategories from '../components/admin/category/SubCategories.vue';
import SubCategoryCeate from '../components/admin/category/SubCategoryCreate.vue';
import SubCategoryUpdate from '../components/admin/category/SubCategoryUpdate.vue';

import Products from '../components/admin/product/Products.vue';
import ProductsCreate from '../components/admin/product/ProductsCreate.vue';

import Brands from '../components/admin/product/Brands.vue';
import BrandsCreate from '../components/admin/product/BrandsCreate.vue';

import Banners from '../components/admin/coupon/Banners.vue';
import BannersCreate from '../components/admin/coupon/BannersCreate.vue';

import Coupons from '../components/admin/coupon/Coupons.vue';
import CouponsCreate from '../components/admin/coupon/CouponsCreate.vue';

import Orders from '../components/admin/orders/Orders.vue';
import Users from '../components/admin/report/Users.vue';
import FeedBack from '../components/admin/report/FeedBack.vue';
 

const routes = [
    { path: '/', component: Deshboard },
    { path: '/deshboard', component: Deshboard },
    { path: '/admins/login', component: Login },

    { path: '/categories', component: Categories },
    { path: '/category-create', component: CategoryCreate },
    { path: '/category-update/:id', component: CategoryUpdate },

    { path: '/subcategories', component: SubCategories },
    { path: '/subcategory-ceate', component: SubCategoryCeate },
    { path: '/subcategory-update/:id', component: SubCategoryUpdate },



    { path: '/products', component: Products },
    { path: '/products-create', component: ProductsCreate },

    { path: '/brands', component: Brands },
    { path: '/brands-create', component: BrandsCreate },

    { path: '/banners', component: Banners },
    { path: '/create-banner', component: BannersCreate },

    { path: '/coupons', component: Coupons },
    { path: '/coupons-create', component: CouponsCreate },

    { path: '/orders', component: Orders },
    { path: '/users', component: Users },
    { path: '/feedbacks', component: FeedBack },





];

const router = createRouter({
    history: createWebHistory(),
    routes,
});

export default router;