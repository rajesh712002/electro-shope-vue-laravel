<template>
    <AdminLayout>
        <template v-slot:content>
            <div class="content-wrapper">
                <!-- Content Header -->
                <section class="content-header">
                    <div class="container-fluid my-2">
                        <div v-if="statusMessage" class="alert alert-success">
                            {{ statusMessage }}
                        </div>
                        <div v-if="errorMessage" class="alert alert-danger">
                            {{ errorMessage }}
                        </div>
                        <div class="row mb-2">
                            <div class="col-sm-6">
                                <h1>Orders</h1>
                            </div>
                            <div class="col-sm-6 text-left">
                                <a href="{{ route('ordersExcel') }}" class="btn btn-warning">Export Data</a>
                            </div>
                        </div>
                    </div>
                </section>

                <!-- Main Content -->
                <section class="content">
                    <div class="container-fluid">
                        <div class="card">
                            <form @submit.prevent="fetchOrders">
                                <div class="card-header">
                                    <div class="card-tools">
                                        <div class="input-group" style="width: 250px;">
                                            <input type="text" v-model="searchKeyword" class="form-control float-right"
                                                placeholder="Search" />
                                            <div class="input-group-append">
                                                <button type="submit" class="btn btn-default">
                                                    <i class="fas fa-search"></i>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </form>

                            <!-- Orders Table -->
                            <div class="card-body table-responsive p-0">
                                <table class="table table-hover text-nowrap">
                                    <thead>
                                        <tr>
                                            <th>Orders #</th>
                                            <th>Customer</th>
                                            <th>Delivery Address</th>
                                            <th>Email</th>
                                            <th>Phone</th>
                                            <th>Status</th>
                                            <th>Payment Status</th>
                                            <th>Total</th>
                                            <th>Date Purchased</th>
                                            <th>Refund</th>
                                        </tr>
                                    </thead>
                                    <!-- <tbody>
                                        <tr v-for="order in orders" :key="order.id">
                                            <td> -->
                                    <!-- <a :href="'{{ route('admin.orderdetail', '') }}' + '/' + order.id">{{
                                                    order.id
                                                }}</a> -->
                                    <!-- {{ order.id }}
                                            </td>
                                            <td>{{ order.user.name }}</td>
                                            <td>
                                                {{ order.first_name }} {{ order.last_name }}<br />
                                                {{ order.address }}, {{ order.apartment }}, {{ order.pincode }}<br />
                                                {{ order.state }}, {{ order.city }}
                                            </td>
                                            <td>{{ order.email }}</td>
                                            <td>{{ order.mobile }}</td>
                                            <td>
                                                <button :class="statusClass(order.status)" class="btn">
                                                    <span :class="statusIcon(order.status)"></span> {{ order.status }}
                                                </button>
                                            </td>
                                            <td>{{ order.payment_status }}</td>
                                            <td><i class="fa fa-inr" aria-hidden="true"></i> {{ order.grand_total }}
                                            </td>
                                            <td>{{ formatDate(order.created_at) }}</td>
                                            <td v-if="canRefund(order)">
                                                <form :action="refundUrl(order)" method="POST">
                                                    @csrf
                                                    <button type="submit" class="btn btn-secondary">Refund</button>
                                                </form>
                                            </td>
                                        </tr>
                                    </tbody> -->

                                    <tbody>
                                        <tr v-for="order in orders" :key="order.id">
                                            <td>{{ order.id }}</td>
                                            <td>{{ order.user ? order.user.name : 'N/A' }}</td>
                                            <td>
                                                {{ order.first_name }} {{ order.last_name }}<br />
                                                {{ order.address }}, {{ order.apartment ?? '' }}, {{ order.pincode
                                                }}<br />
                                                {{ order.state }}, {{ order.city }}
                                            </td>
                                            <td>{{ order.email }}</td>
                                            <td>{{ order.mobile }}</td>
                                            <td>
                                                <button :class="statusClass(order.status)" class="btn">
                                                    <span :class="statusIcon(order.status)"></span> {{ order.status }}
                                                </button>
                                            </td>
                                            <td>{{ order.payment_status }}</td>
                                            <td><i class="fa fa-inr" aria-hidden="true"></i> {{ order.grand_total }}
                                            </td>
                                            <td>{{ formatDate(order.created_at) }}</td>
                                            <!-- <td v-if="canRefund(order)">
                                                <form :action="refundUrl(order)" method="POST">
                                                    @csrf
                                                    <button type="submit" class="btn btn-secondary">Refund</button>
                                                </form>
                                            </td> -->
                                        </tr>
                                    </tbody>

                                </table>
                            </div>

                            <!-- Pagination -->
                            <div class="card-footer clearfix">
                                <div v-if="pagination && pagination.length > 0">
                                    <ul class="pagination">
                                        <li v-for="(link, index) in pagination" :key="index" class="page-item">
                                            <button v-if="link.url" @click="goToPage(link.label)" class="page-link"
                                                :class="{ 'disabled': link.label === '« Previous' || link.label === 'Next »' }"
                                                v-html="link.label"></button>
                                        </li>
                                    </ul>
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
import axios from "axios";
export default {
    components: {
        AdminLayout
    },
    data() {
        return {
            orders: { data: [] },
            pagination: "",
            searchKeyword: "",
            currentPage: 1,
        };
    },
    methods: {
        async fetchOrders() {
            try {
                const response = await axios.get(`/api/orders-report`, {
                    params: { search: this.searchKeyword, page: this.currentPage }
                });
                console.log("hi", response);
                this.orders = response.data.order;
                this.pagination = response.data.pagination;
            } catch (error) {
                console.error('Error fetching orders:', error);
            }
        },
        statusClass(status) {
            switch (status) {
                case 'pending':
                    return 'btn-info';
                case 'shipped':
                    return 'btn-primary';
                case 'out for delivery':
                    return 'btn-warning';
                case 'delivered':
                    return 'btn-success';
                case 'cancelled':
                    return 'btn-danger';
                case 'refunded':
                    return 'btn-secondary';
                default:
                    return '';
            }
        },
        statusIcon(status) {
            switch (status) {
                case 'pending':
                    return 'fa fa-bars';
                case 'shipped':
                case 'out for delivery':
                    return 'fa fa-cog fa-spin';
                case 'delivered':
                    return 'fa fa-check-circle';
                case 'cancelled':
                    return 'fa fa-close';
                case 'refunded':
                    return 'fa fa-coins';
                default:
                    return '';
            }
        },
        formatDate(date) {
            return new Date(date).toLocaleDateString('en-GB');
        },
        canRefund(order) {
            return order.status === 'cancelled' && order.payment_id !== '';
        },
        // refundUrl(order) {
        //     if (order.payment_status === 'paid with Stripe Card') {
        //         return '{{ route('refund') }}';
        //     } else if (order.payment_status === 'paid with BraintreeCard') {
        //         return '{{ route('braintree.refund', '') }}' + '/' + order.id;
        //     } else if (order.payment_status === 'paid with PayPal') {
        //         return '{{ route('paypal.refund', '') }}' + '/' + order.id;
        //     }
        // },
        searchOrders() {
            this.fetchOrders();
        },
        goToPage(pageNumber) {
            this.currentPage = pageNumber;
            this.fetchOrders();
        }
    },
    mounted() {
        this.fetchOrders();
        if (this.$route.query.success) {
            this.successMessage = this.$route.query.success;
        }
    }
};
</script>

<style scoped>
/* Add your custom styles here */
</style>