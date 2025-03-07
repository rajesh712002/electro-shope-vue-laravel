<template>
    <Header />
    <div>
        <!-- Header -->
        <!-- <header>
            <nav class="navbar navbar-expand-lg navbar-light bg-light">
                <div class="container">
                    <router-link class="navbar-brand" to="/">Electro-Shop</router-link>
                </div>
            </nav>
        </header> -->

        <!-- Breadcrumb -->
        <section class="section-5 pt-3 pb-3 mb-3 bg-white">
            <div class="container">
                <div class="light-font">
                    <ol class="breadcrumb primary-color mb-0">
                        <li class="breadcrumb-item">
                            <router-link class="white-text" to="/">Home</router-link>
                        </li>
                        <li class="breadcrumb-item active">Shop</li>
                    </ol>
                </div>
            </div>
        </section>

        <!-- Search Bar -->
        <div class="container mb-3">
            <div class="row">
                <div class="col-lg-12 col-12 text-right d-flex justify-content-end align-items-center">
                    <form @submit.prevent="searchProducts">
                        <div class="input-group">
                            <input type="text" v-model="keyword" placeholder="Search For Products" class="form-control"
                                aria-label="Search For Products">
                            <span class="input-group-text">
                                <button type="submit" class="btn btn-default">
                                    <i class="fa fa-search"></i>
                                </button>
                            </span>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Main Content -->
        <section class="section-6 pt-5">
            <div class="container">
                <div class="row">
                    <!-- Sidebar -->
                    <div class="col-md-3 sidebar">
                        <div class="sub-title">
                            <h2>Categories</h2>
                        </div>

                        <div class="card">
                            <div class="card-body">
                                <div class="accordion" id="categoryAccordion">
                                    <template v-for="(category, index) in categories" :key="category.id">
                                        <div v-if="category.status == 1" class="accordion-item">
                                            <h2 class="accordion-header" :id="'heading-' + index">
                                                <button class="accordion-button"
                                                    :class="{ 'text-danger': categorySelected === category.slug }"
                                                    @click="toggleCategory(category.slug)" data-bs-toggle="collapse"
                                                    :data-bs-target="'#collapse-' + index"
                                                    :aria-expanded="categorySelected === category.slug"
                                                    :aria-controls="'collapse-' + index">
                                                    {{ category.name }}
                                                </button>
                                            </h2>

                                            <div :id="'collapse-' + index" class="accordion-collapse collapse"
                                                :class="{ show: categorySelected === category.slug }"
                                                data-bs-parent="#categoryAccordion">
                                                <div class="accordion-body">
                                                    <ul v-if="category.subcategory && category.subcategory.length > 0"
                                                        class="list-unstyled">
                                                        <li v-for="subcategory in category.subcategory"
                                                            :key="subcategory.id">
                                                            <button
                                                                @click="filterBySubcategory(category.slug, subcategory.slug)"
                                                                class="dropdown-item nav-link">
                                                                {{ subcategory.subcate_name }}
                                                            </button>
                                                        </li>
                                                    </ul>
                                                </div>
                                            </div>
                                        </div>
                                    </template>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Product List -->
                    <div class="col-md-9">
                        <div class="row pb-3">
                            <div class="col-12 pb-1">
                                <div class="d-flex align-items-center justify-content-end mb-4">
                                    <div class="ml-2">
                                        <select v-model="sort" class="form-control">
                                            <option value="">---Sort---</option>
                                            <option value="latest">Latest</option>
                                            <option value="price_desc">Price High</option>
                                            <option value="price_asc">Price Low</option>
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <div v-if="message" class="alert alert-success">{{ message }}</div>

                            <div class="col-md-4" v-for="product in products" :key="product.id">
                                <div class="card product-card">
                                    <div class="product-image position-relative">
                                        <img v-if="product.product_images && product.product_images.length > 0"
                                            :src="'/admin_assets/images/' + product.product_images[0].images"
                                            width="100" alt="Product Image" />
                                        <img v-else-if="product.image" :src="'/admin_assets/images/' + product.image"
                                            width="100" alt="Default Image" />
                                    </div>

                                    <div class="card-body text-center">
                                        <router-link class="h6 link" :to="'/product/' + product.slug">
                                            {{ product.prod_name }}
                                        </router-link>

                                        <div class="price mt-2">
                                            <span class="h5"><strong><i class="fa fa-inr"></i> {{ product.price
                                                    }}</strong></span>
                                            <span class="h6 text-underline"><del>{{ product.compare_price
                                                    }}</del></span>
                                            <div class="text-secondary">InStock: {{ product.qty }}</div>
                                        </div>

                                        <button class="btn btn-dark mt-2" @click="addToCart(product)">Add To
                                            Cart</button>
                                    </div>
                                </div>
                            </div>

                            <!-- Pagination -->
                            <nav class="mt-4">
                                <ul class="pagination">
                                    <li v-for="link in pagination.links" :key="link.label" class="page-item">
                                        <a class="page-link" @click.prevent="changePage(link.url)">{{ link.label }}</a>
                                    </li>
                                </ul>
                            </nav>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
</template>


<script>
import axios from "axios";
import Header from "../include/Header.vue";

export default {
    components: {
        Header
    },
    data() {
        return {
            categories: [],
            products: [],
            pagination: {},
            categorySelected: null,
            subcategorySelected: null,
            sort: "",
            keyword: "",
            message: "",
        };
    },
    mounted() {
        this.fetchProducts();
        this.fetchCategories();
    },
    methods: {
        async fetchProducts(page = 1) {
            console.log("Fetching products with:", {
                categoryslug: this.categorySelected,
                subcategoryslug: this.subcategorySelected,
                sort: this.sort,
                keyword: this.keyword,
                page: page
            });

            try {
                const response = await axios.get("/api/shop", {
                    params: {
                        categoryslug: this.categorySelected || "",
                        subcategoryslug: this.subcategorySelected || "",
                        sort: this.sort,
                        keyword: this.keyword,
                        page: page,
                    }
                });

                this.products = response.data.products.data;
                this.pagination = response.data.products;
            } catch (error) {
                console.error("Error fetching products:", error);
            }
        },

        async fetchCategories() {
            try {
                const response = await axios.get('/api/get-category');
                this.categories = response.data.category;
            } catch (error) {
                console.error('Error fetching categories:', error);
            }
        },

        toggleCategory(categorySlug) {
            this.categorySelected = this.categorySelected === categorySlug ? null : categorySlug;
            this.subcategorySelected = null;
            console.log("Selected Category:", this.categorySelected);
            this.fetchProducts();
        },

        filterBySubcategory(categorySlug, subcategorySlug) {
            this.categorySelected = categorySlug;
            this.subcategorySelected = subcategorySlug;
            console.log("Selected Subcategory:", this.subcategorySelected);
            this.fetchProducts();
        },

        searchProducts() {
            console.log("Searching for:", this.keyword);
            this.fetchProducts();
        },

        changePage(url) {
            if (!url) return;
            const page = new URL(url).searchParams.get("page");
            if (page) {
                this.fetchProducts(page);
            }
        }
    },

    watch: {
        sort() {
            console.log("Sort changed to:", this.sort);
            this.fetchProducts();
        }
    }
};
</script>
