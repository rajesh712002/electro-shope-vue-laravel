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
                                <a href="{{ route('usersExcel') }}" class="btn btn-warning">Export Data</a>
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
                                <table class="table table-hover text-nowrap" border="2" id="userTable">
                                    <thead>
                                        <tr>
                                            <th>User ID</th>
                                            <th>User Name</th>
                                            <th>User Email</th>
                                        </tr>
                                    </thead>
                                    <tbody v-if="users.length > 0">
                                        <tr v-for="user in users" :key="user.id">
                                            <td>{{ user.id }}</td>
                                            <td>{{ user.name }}</td>
                                            <td>{{ user.email }}</td>
                                        </tr>
                                    </tbody>
                                    <tbody v-else>
                                        <tr>
                                            <td colspan="3" class="text-center">No users found</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>

                            <div class="card-footer clearfix">
                                <div class="pagination-container">
                                    <pagination :data="pagination" @pagination-change-page="fetchUsers"></pagination>
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
            users: [],
            keyword: '',
            pagination: {},
        };
    },
    methods: {
        fetchUsers(page = 1) {
            axios
                .get(`${window.location.origin}/admin/users`, {
                    params: { keyword: this.keyword, page },
                })
                .then((response) => {
                    this.users = response.data.data;
                    this.pagination = response.data.pagination;
                });
        },
        searchUsers() {
            this.fetchUsers();
        },
    },
    mounted() {
        this.fetchUsers();
    },
};
</script>

<style scoped>
/* Add any scoped styles you want here */
</style>
