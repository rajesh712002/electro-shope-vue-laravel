<template>
    <AdminLayout>
        <template v-slot:content>
            <div class="content-wrapper">
                <section class="content-header">
                    <div class="container-fluid my-2">
                        <div class="row mb-2">
                            <div class="col-sm-6">
                                <h1>Coupon Codes</h1>
                            </div>
                            <div class="col-sm-6 text-right">
                                <router-link to="/coupons-create" class="btn btn-primary">New Coupon</router-link>
                            </div>
                        </div>
                    </div>
                </section>

                <section class="content">
                    <div class="container-fluid">
                        <div v-if="message" class="alert alert-info">
                            {{ message }}
                        </div>

                        <form @submit.prevent="searchCoupons">
                            <div class="card">
                                <div class="card-header">
                                    <div class="card-tools">
                                        <div class="input-group" style="width: 250px;">
                                            <input type="text" v-model="keyword" class="form-control float-right"
                                                placeholder="Search" />
                                            <div class="input-group-append">
                                                <button type="submit" class="btn btn-default">
                                                    <i class="fas fa-search"></i>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="card-body table-responsive p-0">
                                    <table class="table table-hover text-nowrap" border="2">
                                        <thead>
                                            <tr>
                                                <th>Coupon Code ID</th>
                                                <th>Coupon Code</th>
                                                <th>Coupon Name</th>
                                                <th>Max Uses</th>
                                                <th>Max User Uses</th>
                                                <th>Type</th>
                                                <th>Discount Amount</th>
                                                <th>Minimum Amount</th>
                                                <th>Starts At</th>
                                                <th>Expires At</th>
                                                <th>Description</th>
                                                <th>Status</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr v-for="coupon in coupons" :key="coupon.id">
                                                <td>{{ coupon.id }}</td>
                                                <td>{{ coupon.code }}</td>
                                                <td>{{ coupon.name }}</td>
                                                <td>{{ coupon.max_uses }}</td>
                                                <td>{{ coupon.max_uses_user }}</td>
                                                <td>{{ coupon.type }}</td>
                                                <td>{{ coupon.discount_amount }}</td>
                                                <td>{{ coupon.min_amount }}</td>
                                                <td>{{ coupon.starts_at }}</td>
                                                <td>{{ coupon.expires_at }}</td>
                                                <td>{{ coupon.description }}</td>
                                                <td>
                                                    <svg v-if="coupon.status === 1"
                                                        class="text-success-500 h-6 w-6 text-success" fill="none"
                                                        viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"
                                                        aria-hidden="true">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                                    </svg>
                                                    <svg v-else class="text-danger h-6 w-6"
                                                        xmlns="http://www.w3.org/2000/svg" fill="none"
                                                        viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"
                                                        aria-hidden="true">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z">
                                                        </path>
                                                    </svg>
                                                </td>
                                                <td>
                                                    <router-link :to="'/coupons-update/' + coupon.id"
                                                        class="text-primary">
                                                        <svg class="filament-link-icon w-4 h-4 mr-1"
                                                            xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"
                                                            fill="currentColor" aria-hidden="true">
                                                            <path
                                                                d="M13.586 3.586a2 2 0 112.828 2.828l-.793.793-2.828-2.828.793-.793zM11.379 5.793L3 14.172V17h2.828l8.38-8.379-2.83-2.828z">
                                                            </path>
                                                        </svg>
                                                    </router-link>

                                                    <button @click="deleteCoupon(coupon.id)" class="text-danger">
                                                        <svg class="filament-link-icon w-4 h-4 mr-1"
                                                            xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"
                                                            fill="currentColor" aria-hidden="true">
                                                            <path fill-rule="evenodd"
                                                                d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z"
                                                                clip-rule="evenodd"></path>
                                                        </svg>
                                                    </button>
                                                </td>
                                            </tr>
                                        </tbody>
                                        <!-- <tbody v-else>
                                            <tr>
                                                <td colspan="13" class="text-center">No coupons found</td>
                                            </tr>
                                        </tbody> -->
                                    </table>
                                </div>

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
                        </form>
                    </div>
                </section>
            </div>
        </template>
    </AdminLayout>
</template>

<script>
import axios from 'axios';
import AdminLayout from '../../admin/Layouts/AdminLayout.vue';

//   import Pagination from 'vue-pagination-2';

export default {
    components: {
        AdminLayout
        //   Pagination,
    },
    data() {
        return {
            coupons: { data: [] },
            pagination: "",
            searchKeyword: "",
            currentPage: 1,
        };
    },
    methods: {
        async fetchCoupons() {
            try {
                const response = await axios.get(`/api/coupon-show`, {
                    params: { keyword: this.searchKeyword, page: this.currentPage }
                });
                console.log("hi", response);
                this.coupons = response.data.discount;
                this.pagination = response.data.pagination;
            } catch (error) {
                console.error('Error fetching coupons:', error);
            }
        },
        searchCoupons() {
            this.fetchCoupons();
        },
        deleteCoupon(id) {
            if (confirm("Do you really want to delete this record?")) {
                axios
                    .delete(`/api/delete-coupon/${id}`)
                    .then(() => {
                        this.fetchCoupons(); 
                    })
                    .catch((error) => {
                        this.message = 'Error deleting coupon';
                        console.error(error);
                    });
            }
        },

        searchCoupons() {
            this.fetchCoupons();
        },
        goToPage(pageNumber) {
            this.currentPage = pageNumber;
            this.fetchCoupons();
        }
    },
    mounted() {
        this.fetchCoupons();
        if (this.$route.query.success) {
            this.successMessage = this.$route.query.success;
        }
    },
};
</script>

<style scoped>
/* Add any scoped styles here */
</style>