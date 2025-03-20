import { createRouter, createWebHistory } from "vue-router";
import { createPinia } from "pinia";  
import { useAuthStore } from "../stores/auth.js";
import { useAdminAuthStore } from "../stores/adminAuth.js";

const pinia = createPinia(); 
//User
import Home from '../components/user/Home.vue';
import Header from '../components/user/include/Header.vue';
import Cart from '../components/user/CartWishlist/Cart.vue';
import Profile from '../components/user/setting/Profile.vue';
//Admin
import Deshboard from '../components/admin/Deshboard.vue';
import AdminLayout from '../components/admin/Layouts/AdminLayout.vue';
import Login from '../components/admin/auth/Login.vue';
import ChangePassword from '../components/admin/auth/ChangePassword.vue';

import Categories from '../components/admin/category/Categories.vue';
import CategoryCreate from '../components/admin/category/CategoryCreate.vue';
import CategoryUpdate from '../components/admin/category/CategoryUpdate.vue';

import SubCategories from '../components/admin/category/SubCategories.vue';
import SubCategoryCeate from '../components/admin/category/SubCategoryCreate.vue';
import SubCategoryUpdate from '../components/admin/category/SubCategoryUpdate.vue';

import Products from '../components/admin/product/Products.vue';
import ProductsCreate from '../components/admin/product/ProductsCreate.vue';
import ProductsUpdate from '../components/admin/product/ProductsUpdate.vue';

import Brands from '../components/admin/product/Brands.vue';
import BrandsCreate from '../components/admin/product/BrandsCreate.vue';
import BrandsUpdate from '../components/admin/product/BrandsUpdate.vue';

import Banners from '../components/admin/coupon/Banners.vue';
import BannersCreate from '../components/admin/coupon/BannersCreate.vue';
import BannerUpdates from '../components/admin/coupon/BannerUpdates.vue';

import Coupons from '../components/admin/coupon/Coupons.vue';
import CouponsCreate from '../components/admin/coupon/CouponsCreate.vue';
import CouponsUpdate from '../components/admin/coupon/CouponsUpdate.vue';

import Orders from '../components/admin/orders/Orders.vue';
import OrdersView from '../components/admin/orders/OrdersView.vue'
import Users from '../components/admin/report/Users.vue';
import FeedBack from '../components/admin/report/FeedBack.vue';
 


import SettingSideBar from '../components/user/setting/SettingSideBar.vue';
import Wishlist from '../components/user/setting/Wishlist.vue';
import Order from '../components/user/setting/Order.vue';
import ChangePasswordUser from '../components/user/setting/ChangePassword.vue';
import UserLogin from '../components/user/auth/Login.vue';
import Register from '../components/user/auth/Register.vue';
import OrderDetail from '../components/user/setting/OrderDetail.vue';
import ViewProduct from '../components/user/Shope/ViewProduct.vue';
import Shope from '../components/user/Shope/Shope.vue';
import Checkout from '../components/user/Shope/Checkout.vue';
import Braintree from '../components/user/Shope/Braintree.vue';
import ForgetPassword from '../components/user/auth/ForgetPassword.vue';
import ResetForgetPassword from '../components/user/auth/ResetForgetPassword.vue';
const routes = [
    //User
    { path: '/', component: Home },
    { path: '/header', component: Header },
    { path: '/cart', component: Cart },
    { path: '/profile', component: Profile , meta: { requiresAuth: true }},
    { path: '/setting-sidebar', component: SettingSideBar },
    { path: '/wishlist', component: Wishlist },
    { path: '/my-order', component: Order },
    { path: '/user-change-password', component: ChangePasswordUser },
    { path: '/user-register', component: Register },
    { path: '/user-login', component: UserLogin },
    { path: '/order-detail/:id', component: OrderDetail },
    { path: '/view-product/:slug', component: ViewProduct },
    { path: '/shop', component: Shope },
    { path: '/checkout', component: Checkout , meta: { requiresAuth: true }},
    { path: '/braintree', component: Braintree, name: 'braintree-payment'},
    // { path: '/forget-password/:token', component: ForgetPassword },
    { path: '/forget-password', component: ForgetPassword },
    { path: '/reset-forget-password/:token', component: ResetForgetPassword },









    //Admin
    // { path: '/', component: Login },
    { path: '/deshboard', component: Deshboard , meta: { requiresAuth: true, role: "admin" }},
    { path: '/admin-login', component: Login },
    { path: '/admin/change-password', component: ChangePassword , meta: { requiresAuth: true, role: "admin" }},

    { path: '/categories', component: Categories , meta: { requiresAuth: true, role: "admin" }},
    { path: '/category-create', component: CategoryCreate , meta: { requiresAuth: true, role: "admin" }},
    { path: '/category-update/:id', component: CategoryUpdate , meta: { requiresAuth: true, role: "admin" }},

    { path: '/subcategories', component: SubCategories , meta: { requiresAuth: true, role: "admin" }},
    { path: '/subcategory-ceate', component: SubCategoryCeate , meta: { requiresAuth: true, role: "admin" }},
    { path: '/subcategory-update/:id', component: SubCategoryUpdate , meta: { requiresAuth: true, role: "admin" }},

    { path: '/products', component: Products , meta: { requiresAuth: true, role: "admin" }},
    { path: '/products-create', component: ProductsCreate , meta: { requiresAuth: true, role: "admin" }},
    { path: '/products-update/:id', component: ProductsUpdate , meta: { requiresAuth: true, role: "admin" }},


    { path: '/brands', component: Brands , meta: { requiresAuth: true, role: "admin" }},
    { path: '/brands-create', component: BrandsCreate , meta: { requiresAuth: true, role: "admin" }},
    { path: '/brands-update/:id', component: BrandsUpdate , meta: { requiresAuth: true, role: "admin" }},

    { path: '/banners', component: Banners , meta: { requiresAuth: true, role: "admin" }},
    { path: '/create-banner', component: BannersCreate , meta: { requiresAuth: true, role: "admin" }},
    { path: '/update-banner/:id', component: BannerUpdates , meta: { requiresAuth: true, role: "admin" }},


    { path: '/coupons', component: Coupons , meta: { requiresAuth: true, role: "admin" }},
    { path: '/coupons-create', component: CouponsCreate , meta: { requiresAuth: true, role: "admin" }},
    { path: '/coupons-update/:id', component: CouponsUpdate , meta: { requiresAuth: true, role: "admin" }},


    { path: '/orders', component: Orders , meta: { requiresAuth: true, role: "admin" }},
    { path: '/orders-view/:id', component: OrdersView , meta: { requiresAuth: true, role: "admin" }},

    { path: '/users', component: Users , meta: { requiresAuth: true, role: "admin" }},
    { path: '/feedbacks', component: FeedBack , meta: { requiresAuth: true, role: "admin" }},





];

const router = createRouter({
    history: createWebHistory(),
    routes,
});

// router.beforeEach((to, from, next) => {
//     const authStore = useAuthStore(pinia);  

//     console.log("Route Guard - Checking Auth:", authStore.token);

//     if (to.meta.requiresAuth && !authStore.isAuthenticated) {
//         console.log("Route NOT Authenticated - Redirecting");
//         next("/user-login");  
//     } else {
//         next();
//     }
// });

router.beforeEach((to, from, next) => {
    const authStore = useAuthStore();
    const adminAuthStore = useAdminAuthStore();

    console.log("Route Guard - Checking Auth:", authStore.token, adminAuthStore.token);

    if (to.meta.requiresAuth) {
        if (to.meta.role === "admin") {
            if (!adminAuthStore.isAuthenticated) {
                console.log("Admin NOT Authenticated - Redirecting to Admin Login");
                return next("/admin-login");
            }
        } else { // Default to user authentication if no role is provided
            if (!authStore.isAuthenticated) {
                console.log("User NOT Authenticated - Redirecting to User Login");
                return next("/user-login");
            }
        }
    }

    next();
});



export default router;