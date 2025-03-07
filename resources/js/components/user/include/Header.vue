<template>
    <div>
        <div class="bg-light top-header">
            <div class="container">
                <div class="row align-items-center py-3 d-none d-lg-flex justify-content-between">
                    <div class="col-lg-4 logo">
                        <router-link to="/" class="text-decoration-none">
                            <span class="h2 text-uppercase text-primary bg-dark px-2">ELECTRO</span>
                            <span class="h2 text-uppercase text-dark bg-primary px-2 ml-n1">SHOP</span>
                        </router-link>
                    </div>
                    <div class="col-lg-6 col-6 text-left d-flex justify-content-end align-items-center">
                        <router-link to="/profile" class="nav-link text-dark">My Account</router-link>
                    </div>
                </div>
            </div>
        </div>

        <header class="bg-dark">
            <div class="container">
                <nav class="navbar navbar-expand-xl" id="navbar">
                    <button class="navbar-toggler menu-btn" type="button" data-bs-toggle="collapse"
                        data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent"
                        aria-expanded="false" aria-label="Toggle navigation">
                        <i class="navbar-toggler-icon fas fa-bars"></i>
                    </button>

                    
                    <template v-for="category in categories" :key="category.id">
                        <li v-if="category.status == 1" class="nav-item dropdown">
                            <button class="btn btn-dark dropdown-toggle" data-bs-toggle="dropdown">
                                {{ category.name }}
                            </button>
                            <ul v-if="category.subcategory && category.subcategory.length > 0"
                                class="dropdown-menu dropdown-menu-dark">
                                <li v-for="subcategory in category.subcategory" :key="subcategory.id">
                                    <router-link :to="`/shop/`"
                                        class="dropdown-item nav-link">
                                        {{ subcategory.subcate_name }}
                                    </router-link>
                                </li>
                            </ul>
                        </li>
                    </template>
                    <div class="collapse navbar-collapse" id="navbarSupportedContent">
                        <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                        </ul>
                    </div>

                    <div class="right-nav py-0">
                        <router-link to="/cart" class="ml-3 d-flex pt-2">
                            <i class="fas fa-shopping-cart text-primary">
                                <span style="color: white">{{ cartCount }}</span>
                            </i>
                        </router-link>
                    </div>
                </nav>
            </div>
        </header>

        <div class="overlay" v-if="loading">
            <div class="spinner-container">
                <div class="spinner-border" role="status">
                    <span class="visually-hidden">Loading...</span>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import axios from 'axios';

export default {
    data() {
        return {
            categories: { data: [] },
            cartCount: 0,
            loading: false,
        };
    },
    created() {
        this.fetchCategories();
        this.fetchCartCount();
    },
    methods: {
        async fetchCategories() {
            try {
                this.loading = true;
                const response = await axios.get('/api/get-category');
                console.log(response);
                this.categories = response.data.category;
                console.log(this.categories);
            } catch (error) {
                console.error('Error fetching categories:', error);
            } finally {
                this.loading = false;
            }
        },
        async fetchCartCount() {
            try {
                const response = await axios.get('/api/cart/count');
                this.cartCount = response.data.count;
            } catch (error) {
                console.error('Error fetching cart count:', error);
            }
        }
    }
};
</script>

<style>
.overlay {
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background-color: rgba(0, 0, 0, 0.5);
    display: flex;
    justify-content: center;
    align-items: center;
    z-index: 9999;
}

.spinner-container {
    display: flex;
    justify-content: center;
    align-items: center;
}

.spinner-border {
    width: 10rem;
    height: 10rem;
}
</style>
