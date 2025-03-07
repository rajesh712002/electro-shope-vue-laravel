import { createRouter, createWebHistory } from 'vue-router';
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
    { path: '/profile', component: Profile },
    { path: '/setting-sidebar', component: SettingSideBar },
    { path: '/wishlist', component: Wishlist },
    { path: '/my-order', component: Order },
    { path: '/user-change-password', component: ChangePasswordUser },
    { path: '/user-register', component: Register },
    { path: '/user-login', component: UserLogin },
    { path: '/order-detail/:id', component: OrderDetail },
    { path: '/view-product/:slug', component: ViewProduct },
    { path: '/shop', component: Shope },
    { path: '/checkout', component: Checkout },
    { path: '/braintree', component: Braintree, name: 'braintree-payment'},
    // { path: '/forget-password/:token', component: ForgetPassword },
    { path: '/forget-password', component: ForgetPassword },
    { path: '/reset-forget-password/:token', component: ResetForgetPassword },









    //Admin
    // { path: '/', component: Login },
    { path: '/deshboard', component: Deshboard },
    { path: '/admin/login', component: Login },
    { path: '/admin/change-password', component: ChangePassword },

    { path: '/categories', component: Categories },
    { path: '/category-create', component: CategoryCreate },
    { path: '/category-update/:id', component: CategoryUpdate },

    { path: '/subcategories', component: SubCategories },
    { path: '/subcategory-ceate', component: SubCategoryCeate },
    { path: '/subcategory-update/:id', component: SubCategoryUpdate },

    { path: '/products', component: Products },
    { path: '/products-create', component: ProductsCreate },
    { path: '/products-update/:id', component: ProductsUpdate },


    { path: '/brands', component: Brands },
    { path: '/brands-create', component: BrandsCreate },
    { path: '/brands-update/:id', component: BrandsUpdate },

    { path: '/banners', component: Banners },
    { path: '/create-banner', component: BannersCreate },
    { path: '/update-banner/:id', component: BannerUpdates },


    { path: '/coupons', component: Coupons },
    { path: '/coupons-create', component: CouponsCreate },
    { path: '/coupons-update/:id', component: CouponsUpdate },


    { path: '/orders', component: Orders },
    { path: '/orders-view/:id', component: OrdersView },

    { path: '/users', component: Users },
    { path: '/feedbacks', component: FeedBack },





];

const router = createRouter({
    history: createWebHistory(),
    routes,
});

export default router;