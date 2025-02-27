<template>
    <Header />
    <main>
      <!-- Breadcrumb Section -->
      <section class="section-5 pt-3 pb-3 mb-3 bg-white">
        <div class="container">
          <ol class="breadcrumb primary-color mb-0">
            <li class="breadcrumb-item">
              <router-link class="white-text" to="/shop">Shop</router-link>
            </li>
            <li class="breadcrumb-item"><span class="white-text">My Account</span></li>
            <li class="breadcrumb-item">Settings</li>
          </ol>
        </div>
      </section>
  
      <!-- Orders Section -->
      <section class="section-11">
        <div class="container mt-5">
          <div class="row">
            <div class="col-md-3">
              <SettingSideBar /> <!-- Replace with actual account panel component -->
            </div>
            <div class="col-md-9">
              <div class="card">
                <div class="card-header">
                  <h2 class="h5 mb-0 pt-2 pb-2">My Orders</h2>
                </div>
  
                <div class="card-body p-4">
                  <div v-if="loading" class="text-center">
                    <span class="spinner-border text-primary"></span> Loading...
                  </div>
  
                  <div v-else class="table-responsive">
                    <table class="table">
                      <thead>
                        <tr>
                          <th>Order #</th>
                          <th>Purchased Date</th>
                          <th>Status</th>
                          <th>Total</th>
                          <th>Action</th>
                        </tr>
                      </thead>
                      <tbody>
                        <tr v-for="order in orders" :key="order.id">
                          <td>
                            <router-link :to="`/order-detail/${order.id}`">
                              {{ order.id }}
                            </router-link>
                          </td>
                          <td>{{ formatDate(order.created_at) }}</td>
                          <td>
                            <button type="button" class="btn" :class="getStatusClass(order.status)">
                              {{ capitalize(order.status) }}
                            </button>
                          </td>
                          <td><i class="fa fa-inr"></i> {{ order.grand_total }}</td>
                          <td>
                            <button v-if="order.status === 'pending'" 
                                    @click="deleteOrder(order.id)" 
                                    class="btn btn-sm btn-danger">
                              <i class="fa fa-times"></i>
                            </button>
                          </td>
                        </tr>
                      </tbody>
                    </table>
                  </div>
                </div>
  
                <!-- Pagination -->
                <div class="card-footer clearfix">
                  <nav aria-label="Order Pagination">
                    <ul class="pagination">
                      <li v-for="(link, index) in paginationLinks" :key="index" 
                          class="page-item" :class="{ 'active': link.active }">
                        <button class="page-link" @click="fetchOrders(link.url.split('page=')[1])" 
                                v-html="link.label"></button>
                      </li>
                    </ul>
                  </nav>
                </div>
              </div>
            </div>
          </div>
        </div>
      </section>
    </main>
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
      orders: [],
      paginationLinks: [],
      loading: false,
    };
  },
  methods: {
    // Fetch Orders
    async fetchOrders(page = 1) {
      this.loading = true;
      try {
        const response = await axios.get(`/api/order?page=${page}`);
        console.log(response)
        this.orders = response.data.order.data;
        this.paginationLinks = response.data.order.links;
      } catch (error) {
        console.error("Error fetching orders:", error);
      } finally {
        this.loading = false;
      }
    },

    // Delete Order
    async deleteOrder(orderId) {
      if (!confirm("Do you really want to cancel this order?")) return;
      try {
        await axios.delete(`/user/order`);
        this.orders = this.orders.filter(order => order.id !== orderId);
        alert("Order Cancelled Successfully!");
      } catch (error) {
        console.error("Error deleting order:", error);
      }
    },

    // Get Button Class for Order Status
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

    // Capitalize First Letter
    capitalize(text) {
      return text.charAt(0).toUpperCase() + text.slice(1);
    },

    // Format Date
    formatDate(date) {
      return new Date(date).toLocaleDateString();
    }
  },
  mounted() {
    this.fetchOrders();
  }
};

  </script>
  
  <style scoped>
  /* Add your styles here if needed */
  </style>
  