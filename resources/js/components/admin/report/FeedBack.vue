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
                                <a href="{{ route('ratingsExcel') }}" class="btn btn-warning">Export Data</a>
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
                                    <tbody v-if="ratings.length > 0">
                                        <tr v-for="rating in ratings" :key="rating.id">
                                            <td>
                                                <img :src="`{{ asset('admin_assets/images') }}/${rating.product.image}`"
                                                    width="120" height="120" alt="Product Image" />
                                            </td>
                                            <td>{{ rating.product_id }}</td>
                                            <td>{{ rating.product.prod_name }}</td>
                                            <td>{{ rating.rating }}</td>
                                            <td>{{ rating.username }}</td>
                                            <td>{{ rating.comment }}</td>
                                        </tr>
                                    </tbody>
                                    <tbody v-else>
                                        <tr>
                                            <td colspan="6" class="text-center">No ratings found</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>

                            <div class="card-footer clearfix">
                                <div class="pagination-container">
                                    <pagination :data="pagination" @pagination-change-page="fetchRatings"></pagination>
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
            ratings: [],
            keyword: '',
            pagination: {},
        };
    },
    methods: {
        fetchRatings(page = 1) {
            axios
                .get(`${window.location.origin}/admin/viewRating`, {
                    params: { keyword: this.keyword, page },
                })
                .then((response) => {
                    this.ratings = response.data.data;
                    this.pagination = response.data.pagination;
                });
        },
        searchRatings() {
            this.fetchRatings();
        },
    },
    mounted() {
        this.fetchRatings();
    },
};
</script>

<style scoped>
/* Add any scoped styles here */
</style>