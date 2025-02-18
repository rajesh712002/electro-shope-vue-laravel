<template>
    <AdminLayout>
        <template v-slot:content>
            <div class="content-wrapper">
                <section class="content-header">
                    <div class="container-fluid my-2">
                        <div class="row mb-2">
                            <div class="col-sm-6">
                                <h1>Order: #{{ order.id }}</h1>
                            </div>
                            <div class="col-sm-6 text-right">
                                <router-link to="/orders" class="btn btn-primary">Back</router-link>
                            </div>
                        </div>
                    </div>
                </section>

                <section class="content">
                    <div v-if="loading" class="overlay">
                        <div class="spinner-container">
                            <div class="spinner-border" role="status">
                                <span class="visually-hidden">
                                    <h1>Processing...</h1>
                                </span>
                            </div>
                        </div>
                    </div>

                    <div class="container-fluid">
                        <div class="row">
                            <div class="col-md-9">
                                <div class="card">
                                    <div class="card-header pt-3">
                                        <div class="row invoice-info">
                                            <div class="col-sm-4 invoice-col">
                                                <h1 class="h5 mb-3">Shipping Address</h1>
                                                <address>
                                                    <strong>{{ order.first_name }} {{ order.last_name }}</strong><br>
                                                    {{ order.address }}, {{ order.apartment }}, {{ order.pincode }}<br>
                                                    {{ order.state }}, {{ order.city }}<br>
                                                    <b>Phone:</b> {{ order.mobile }}<br>
                                                    <b>Email:</b> {{ order.email }}
                                                </address>
                                            </div>

                                            <div class="col-sm-4 invoice-col">
                                                <b>Order ID:</b> {{ order_id }}<br>
                                                <b>Total:</b> <i class="fa fa-inr"></i> {{ order.grand_total }}<br>
                                                <b>Status:</b>
                                                <button :class="statusClass(order.status)" class="btn">
                                                    <span v-if="order.status === 'pending'" class="fa fa-bars"></span>
                                                    <span v-else-if="order.status === 'shipped'"
                                                        class="fa fa-cog fa-spin"></span>
                                                    <span v-else-if="order.status === 'out for delivery'"
                                                        class="fa fa-cog fa-spin"></span>
                                                    <span v-else-if="order.status === 'delivered'"
                                                        class="fa fa-check-circle"></span>
                                                    <span v-else-if="order.status === 'cancelled'"
                                                        class="fa fa-close"></span>
                                                    <span v-else-if="order.status === 'refunded'"
                                                        class="fa fa-coins"></span>
                                                    {{ order.status }}
                                                </button>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="card-body table-responsive p-3">
                                        <table class="table table-striped">
                                            <thead>
                                                <tr>
                                                    <th>Product</th>
                                                    <th width="100">Price</th>
                                                    <th width="100">Qty</th>
                                                    <th width="100">Total</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr v-for="item in orderItems" :key="item.id">
                                                    <td>{{ item.name }}</td>
                                                    <td><i class="fa fa-inr"></i> {{ item.price }}</td>
                                                    <td>{{ item.qty }}</td>
                                                    <td>{{ item.price * item.qty }}</td>
                                                </tr>
                                                <tr>
                                                    <th colspan="3" class="text-right">Subtotal:</th>
                                                    <td><i class="fa fa-inr"></i> {{ order.subtotal }}</td>
                                                </tr>
                                                <tr>
                                                    <th colspan="3" class="text-right">Discount:</th>
                                                    <td><i class="fa fa-inr"></i> {{ order.discount ?? '0.00' }}</td>
                                                </tr>
                                                <tr>
                                                    <th colspan="3" class="text-right">Coupon Code:</th>
                                                    <td>{{ order.coupon_code ?? 'null' }}</td>
                                                </tr>
                                                <tr>
                                                    <th colspan="3" class="text-right">Shipping:</th>
                                                    <td>Free</td>
                                                </tr>
                                                <tr>
                                                    <th colspan="3" class="text-right">Grand Total:</th>
                                                    <td><i class="fa fa-inr"></i> {{ order.grand_total }}</td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-3">
                                <div class="card">
                                    <div class="card-body">
                                        <h2 class="h4 mb-3">Order Status</h2>
                                        <form @submit.prevent="updateStatus">
                                            <div class="mb-3">
                                                <select v-model="selectedStatus" class="form-control">
                                                    <option value="pending">Pending</option>
                                                    <option value="shipped">Shipped</option>
                                                    <option value="out for delivery">Out For Delivery</option>
                                                    <option value="delivered">Delivered</option>
                                                    <option value="cancelled">Cancelled</option>
                                                </select>
                                            </div>
                                            <div class="mb-3">
                                                <button type="submit" class="btn btn-primary">Update</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>

                                <div class="card">
                                    <form @submit.prevent="sendInvoiceEmail">
                                        <div class="card-body">
                                            <h2 class="h4 mb-3">Send Invoice Email</h2>
                                            <div class="mb-3">
                                                <select v-model="emailRecipient" class="form-control">
                                                    <option value="customer">Customer</option>
                                                </select>
                                            </div>
                                            <div class="mb-3">
                                                <button type="submit" class="btn btn-primary">Send</button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
               
               
                </section>
            </div>
        </template>
    </AdminLayout>
</template>

<script>
import AdminLayout from '../../admin/Layouts/AdminLayout.vue';
import '@css/admin_assets/plugins/fontawesome-free/css/all.min.css';
import '@css/admin_assets/css/adminlte.min.css';
import '@css/admin_assets/css/custom.css';
import axios from "axios";
export default {
    components: {
        AdminLayout
    },
    data() {
        return {
            order: {data:[]},
            orderItems: [],
            selectedStatus: "",
            emailRecipient: "customer",
            loading: false,
            
        };
    },
    mounted() {
        this.fetchOrderDetails();
        if (this.$route.query.success) {
            this.successMessage = this.$route.query.success;
        }
    },
    methods: {
        async fetchOrderDetails() {
            const orderId = this.$route.params.id;
            this.loading = true;
            try {
                const response = await axios.get(`/api/order-detail/${orderId}`);
                console.log(response)
                this.order = response.data.order_item.order;
                this.orderItems = response.data.order_items;
                this.selectedStatus = this.order.status;
            } catch (error) {
                console.error("Error fetching order details", error);
            } finally {
                this.loading = false;
            }
        },
        async updateStatus() {
            try {
                await axios.put(`/api/update-order-detail/${this.order.id}`, {
                    status: this.selectedStatus,
                });
                this.fetchOrderDetails()
                alert("Order status updated successfully");
            } catch (error) {
                console.error("Error updating order status", error);
            }
        },
        async sendInvoiceEmail() {
            try {
                await axios.post(`/api/send-Invoice-Email/${this.order.id}`);
                alert("Invoice email sent successfully");
            } catch (error) {
                console.error("Error sending invoice email", error);
            }
        },
        statusClass(status) {
            return {
                "btn-info": status === "pending",
                "btn-primary": status === "shipped",
                "btn-warning": status === "out for delivery",
                "btn-success": status === "delivered",
                "btn-danger": status === "cancelled",
                "btn-secondary": status === "refunded",
            };
        },
    },
};
</script>