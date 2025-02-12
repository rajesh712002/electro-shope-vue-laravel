<template>
    <aside class="main-sidebar sidebar-dark-primary elevation-4">
        <div class="sidebar">
            <nav class="mt-2">
                <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                    <li class="nav-item">
                        <router-link to="/deshboard" class="nav-link">
                            <i class="nav-icon fas fa-tachometer-alt"></i>
                            <p>Dashboard</p>
                        </router-link>
                    </li>
                    <li class="nav-item">
                        <router-link to="/categories" class="nav-link">
                            <i class="nav-icon fas fa-file-alt"></i>
                            <p>Category</p>
                        </router-link>
                    </li>
                    <li class="nav-item">
                        <router-link to="/subcategories" class="nav-link">
                            <i class="nav-icon fas fa-file-alt"></i>
                            <p>Sub Category</p>
                        </router-link>
                    </li>
                    <li class="nav-item">
                        <router-link to="/brands" class="nav-link">
                            <i class="nav-icon fas fa-box"></i>
                            <p>Brands</p>
                        </router-link>
                    </li>
                    <li class="nav-item">
                        <router-link to="/products" class="nav-link">
                            <i class="nav-icon fas fa-tag"></i>
                            <p>Products</p>
                        </router-link>
                    </li>
                    <li class="nav-item">
                        <router-link to="/banners" class="nav-link">
                            <i class="nav-icon fa fa-window-restore"></i>
                            <p>Banners</p>
                        </router-link>
                    </li>
                    <li class="nav-item">
                        <router-link to="/coupons" class="nav-link">
                            <i class="fas fa-percent nav-icon"></i>
                            <p>Coupon Code</p>
                        </router-link>
                    </li>
                    <li class="nav-item">
                        <router-link to="/orders" class="nav-link">
                            <i class="nav-icon fas fa-shopping-bag"></i>
                            <p>Orders</p>
                        </router-link>
                    </li>
                    <li class="nav-item">
                        <router-link to="/users" class="nav-link">
                            <i class="nav-icon fas fa-users"></i>
                            <p>Users</p>
                        </router-link>
                    </li>
                    <li class="nav-item">
                        <router-link to="/feedbacks" class="nav-link">
                            <i class="nav-icon fa fa-comments"></i>
                            <p>Feedbacks</p>
                        </router-link>
                    </li>
                </ul>
            </nav>
        </div>
    </aside>
</template>

<script>
export default {
    name: "SideBar",
};
</script>

<style scoped>
/* Add any additional styles here */
</style>
