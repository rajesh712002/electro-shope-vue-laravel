<template>
    <div>
        <Header />
        <main>
            <section class="section-5 pt-3 pb-3 mb-3 bg-white">
                <div class="container">
                    <div class="light-font">
                        <ol class="breadcrumb primary-color mb-0">
                            <li class="breadcrumb-item">
                                <router-link class="white-text" to="#">My Account</router-link>
                            </li>
                            <li class="breadcrumb-item">Settings</li>
                        </ol>
                    </div>
                </div>
            </section>

            <section class="section-11">
                <div class="container mt-5">
                    <div v-if="statusMessage" class="alert alert-success">{{ statusMessage }}</div>

                    <div class="row">
                        <div class="col-md-3">
                            <SettingSideBar />
                        </div>
                        <div class="col-md-9">
                            <div class="card">
                                <div class="card-header">
                                    <h2 class="h5 mb-0 pt-2 pb-2">My Orders</h2>
                                </div>

                                <div class="card-body pb-0">
                                    <div class="card card-sm">
                                        <div class="card-body bg-light mb-3">
                                            <div class="row">
                                                <div class="col-6 col-lg-3">
                                                    <h6 class="heading-xxxs text-muted">Order No:</h6>
                                                    <p v-if="order && order.id" class="mb-lg-0 fs-sm fw-bold">{{
                                                        order.id || 'N/A' }}</p>
                                                </div>
                                                <div class="col-6 col-lg-3">
                                                    <h6 class="heading-xxxs text-muted">{{ order.status }} date:</h6>
                                                    <p class="mb-lg-0 fs-sm fw-bold">
                                                        <time v-if="order.updated_at">{{ formatDate(order.updated_at)
                                                        }}</time>
                                                    </p>
                                                </div>
                                                <div class="col-6 col-lg-3">
                                                    <h6 class="heading-xxxs text-muted">Status:</h6>
                                                    <p class="mb-0 fs-sm fw-bold">
                                                        <button :class="getStatusClass(order.status)">
                                                            <i v-if="order.status === 'pending'" class="fa fa-bars"></i>
                                                            <i v-if="order.status === 'shipped'"
                                                                class="fa fa-cog fa-spin"></i>
                                                            <i v-if="order.status === 'out for delivery'"
                                                                class="fa fa-cog fa-spin"></i>
                                                            <i v-if="order.status === 'delivered'"
                                                                class="fa fa-check-circle"></i>
                                                            <i v-if="order.status === 'cancelled'"
                                                                class="fa fa-close"></i>
                                                            <i v-if="order.status === 'refunded'"
                                                                class="fa fa-coins"></i>
                                                            {{ capitalize(order.status) }}
                                                        </button>
                                                    </p>
                                                </div>
                                                <div class="col-6 col-lg-3">
                                                    <h6 class="heading-xxxs text-muted">Order Amount:</h6>
                                                    <p class="mb-0 fs-sm fw-bold">
                                                        <i class="fa fa-inr"></i> {{ order.grand_total || '0.00' }}
                                                    </p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="card-footer p-3">
                                    <h6 class="mb-7 h5 mt-4">Order Items ({{ orderItems.length }})</h6>
                                    <hr class="my-3" />

                                    <ul>
                                        <li v-for="item in orderItems" :key="item.id" class="list-group-item">
                                            <div class="row align-items-center">
                                                <!-- Image Column -->
                                                <div class="col-4 col-md-3 col-xl-2">
                                                    <router-link :to="'/view-product/' + item.product.slug">
                                                        <img :src="getImageUrl(item.product.image)" class="img-fluid" />
                                                    </router-link>
                                                </div>

                                                <!-- Product Details Column -->
                                                <div class="col-8 col-md-9 col-xl-10">
                                                    <p class="mb-4 fs-sm fw-bold">
                                                        <router-link class="text-body"
                                                            :to="'/view-product/' + item.product.slug">
                                                            {{ item.name }} X <b><u><i>{{ item.qty }}</i></u></b>
                                                        </router-link>
                                                        <br />
                                                        <span class="text-muted">
                                                            <i class="fa fa-inr"></i> {{ item.price }}
                                                        </span>
                                                    </p>
                                                </div>
                                            </div>
                                        </li>

                                    </ul>
                                </div>
                            </div>

                            <div class="card card-lg mb-5 mt-3">
                                <div class="card-body">
                                    <h6 class="mt-0 mb-3 h5">Order Total</h6>
                                    <ul>
                                        <li class="list-group-item d-flex">
                                            <span>Subtotal</span>
                                            <span class="ms-auto"><i class="fa fa-inr"></i> {{ order.subtotal || '0.00'
                                            }}</span>
                                        </li>
                                        <li class="list-group-item d-flex">
                                            <span>Discount</span>
                                            <span class="ms-auto"><i class="fa fa-inr"></i> {{ order.discount || '0.00'
                                            }}</span>
                                        </li>
                                        <li class="list-group-item d-flex">
                                            <span>Coupon Code</span>
                                            <span class="ms-auto">{{ order.coupon_code || 'N/A' }}</span>
                                        </li>
                                        <li class="list-group-item d-flex">
                                            <span>Shipping</span>
                                            <span class="ms-auto">Free</span>
                                        </li>
                                        <li class="list-group-item d-flex fs-lg fw-bold">
                                            <span>Total</span>
                                            <span class="ms-auto"><i class="fa fa-inr"></i> {{ order.grand_total ||
                                                '0.00' }}</span>
                                        </li>
                                    </ul>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </section>
        </main>
    </div>
</template>

<script>
import axios from "axios";
import Header from "../include/Header.vue";
import SettingSideBar from "./SettingSideBar.vue";

export default {
    components: {
        Header,
        SettingSideBar,
    },
    data() {
        return {
            id: this.$route.params.id,
            order: {},
            orderItems: [],
            statusMessage: "",
        };
    },
    methods: {
        async fetchOrder() {
            
            try {
                const response = await axios.get(`/api/order-detail/${this.id}`);
                this.order = response.data.order || {};
                this.orderItems = response.data.order_item || [];
                console.log(response)
            } catch (error) {
                console.error("Error fetching order:", error);
            }
        },

        getStatusClass(status) {
            const statusClasses = {
                pending: "btn-info",
                shipped: "btn-primary",
                "out for delivery": "btn-warning",
                delivered: "btn-success",
                cancelled: "btn-danger",
                refunded: "btn-secondary",
            };
            return statusClasses[status] || "btn-secondary";
        },

        capitalize(text) {
            return text ? text.charAt(0).toUpperCase() + text.slice(1) : "";
        },

        formatDate(date) {
            return new Date(date).toLocaleDateString();
        },

        getImageUrl(imagePath) {
            return imagePath ? `/admin_assets/images/${imagePath}` : "/default-image.jpg";
        },
    },
    mounted() {
        this.fetchOrder();
    },
};
</script>

<style scoped>
/* Add your styles here */
</style>