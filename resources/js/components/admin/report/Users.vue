<template>
    <AdminLayout>
        <template v-slot:content>
            <div class="content-wrapper">
                <section class="content-header">
                    <div class="container-fluid my-2">
                        <div class="row mb-2">
                            <div class="col-sm-6">
                                <h1>Users</h1>
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
                            <form @submit.prevent="searchUsers" id="searchForm">
                                <div class="card-header">
                                    <div class="card-tools">
                                        <div class="input-group" style="width: 250px;">
                                            <input type="text" v-model="searchKeyword" class="form-control float-right"
                                                placeholder="Search users..." />
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
                                <table class="table table-hover text-nowrap" border="2" id="userTable">
                                    <thead>
                                        <tr>
                                            <th>User ID</th>
                                            <th>User Name</th>
                                            <th>User Email</th>
                                            <!-- <th>Actions</th> -->
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr v-for="user in users" :key="user.id">
                                            <td>{{ user.id }}</td>
                                            <td>{{ user.name }}</td>
                                            <td>{{ user.email }}</td>
                                            <!-- <td>
                                                <button @click="deleteUser(user.id)" class="btn btn-danger btn-sm">
                                                    Delete
                                                </button>
                                            </td> -->
                                        </tr>
                                        <!-- </tbody>
                                    <tbody v-else>
                                        <tr>
                                            <td colspan="4" class="text-center">No users found</td>
                                        </tr> -->
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
            users: { data: [] },
            pagination: "",
            searchKeyword: "",
            currentPage: 1,
        };
    },
    mounted() {
        this.fetchUsers();
        if (this.$route.query.success) {
            this.successMessage = this.$route.query.success;
        }
    },
    methods: {
        async fetchUsers() {
            try {
                const response = await axios.get(`/api/users-report`, {
                    params: { search: this.searchKeyword, page: this.currentPage }
                });
                console.log(response)
                this.users = response.data.users;
                this.pagination = response.data.pagination;
            } catch (error) {
                console.error('Error fetching users:', error);
            }
        },
        searchUsers() {
            this.currentPage = 1;
            this.fetchUsers();
        },
        goToPage(pageNumber) {
            this.currentPage = pageNumber;
            this.fetchUsers();
        },
        async getExcel() {
            try {
                const response = await axios.get(`/api/users-excel`, {
                    responseType: 'blob',
                });
                console.log(response)
                const url = window.URL.createObjectURL(new Blob([response.data]));
                const link = document.createElement('a');
                link.href = url;
                link.setAttribute('download', 'users.xlsx'); 
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
/* Add any scoped styles you want here */
</style>
