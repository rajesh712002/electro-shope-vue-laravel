<template>
    <AdminLayout>
        <template v-slot:content>
            <div class="content-wrapper">
                <section class="content-header">
                    <div class="container-fluid my-2">
                        <div class="row mb-2">
                            <div class="col-sm-6">
                                <h1>Feedbacks</h1>
                            </div>
                            <div class="col-sm-6 text-left">
                                <button @click="getExcel" class="btn btn-warning">Export Data</button>
                            </div>
                        </div>
                    </div>
                </section>

                <section class="content">
                    <div class="container-fluid">
                        <div class="card">
                            <form @submit.prevent="searchRatings" id="searchForm">
                                <div class="card-header">
                                    <div class="card-tools">
                                        <div class="input-group" style="width: 250px;">
                                            <input type="text" v-model="searchKeyword" class="form-control float-right"
                                                placeholder="Search feedback..." />
                                            <div class="input-group-append">
                                                <button type="submit" class="btn btn-default">
                                                    <i class="fas fa-search"></i>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </form>

                            <div class="card-body table-responsive p-0">
                                <table class="table table-hover text-nowrap" border="2">
                                    <thead>
                                        <tr>
                                            <th>Image</th>
                                            <th>Product ID</th>
                                            <th>Product Name</th>
                                            <th>Rating</th>
                                            <th>Rated By</th>
                                            <th>Comment</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr v-for="rating in ratings" :key="rating.id">
                                            <!-- <td>
                                                <img :src="`/admin_assets/images/${rating.product.image}`"
                                                    width="120" height="120" alt="Product Image" />
                                            </td> -->
                                            <td v-if="rating.product && rating.product.image">
                                                <img :src="`/admin_assets/images/${rating.product.image}`" width="120"
                                                    height="120" alt="Product Image" />
                                            </td>
                                            <td v-else>
                                                <span class="text-muted">No Image Available</span>
                                            </td>
                                            <td>{{ rating.product_id }}</td>

                                            <!-- <td>{{ rating.product.prod_name }}</td> -->
                                            <td v-if="rating.product">
                                                {{ rating.product.prod_name || 'No Product Name' }}
                                            </td>
                                            <td v-else>
                                                <span class="text-danger">Product Not Found</span>
                                            </td>
                                            <td>{{ rating.rating }}</td>
                                            <td>{{ rating.username }}</td>
                                            <td>{{ rating.comment }}</td>
                                        </tr>
                                    </tbody>
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
            ratings: { data: [] },
            pagination: "",
            searchKeyword: "",
            currentPage: 1,
        };
    },
    mounted() {
        this.fetchRatings();
        if (this.$route.query.success) {
            this.successMessage = this.$route.query.success;
        }
    },
    methods: {
        async fetchRatings() {
            try {
                const response = await axios.get(`/api/feddbacks-report`, {
                    params: { keyword: this.searchKeyword, page: this.currentPage }
                });
                console.log("hi", response);
                this.ratings = response.data.rating;
                this.pagination = response.data.pagination;
            } catch (error) {
                console.error('Error fetching ratings:', error);
            }
        },
        searchRatings() {
            this.fetchRatings();
        },
        goToPage(pageNumber) {
            this.currentPage = pageNumber;
            this.fetchRatings();
        },
        async getExcel() {
            try {
                const response = await axios.get(`/api/ratings-excel`, {
                    responseType: 'blob',
                });
                console.log(response)
                const url = window.URL.createObjectURL(new Blob([response.data]));
                const link = document.createElement('a');
                link.href = url;
                link.setAttribute('download', 'ratings.xlsx'); 
                document.body.appendChild(link);
                link.click();
                link.remove();
                
                alert("Generate successfully");
            } catch (error) {
                console.error("Error updating order status", error);
            }
        },
    },
};
</script>

<style scoped>
/* Add any scoped styles here */
</style>
