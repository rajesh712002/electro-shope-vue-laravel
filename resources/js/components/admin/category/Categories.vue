<template>
  <AdminLayout>
    <template v-slot:content>
      <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
          <div class="container-fluid my-2">
            <div class="row mb-2">
              <div class="col-sm-6">
                <h1>Categories</h1>
              </div>
              <div class="col-sm-6 text-right">
                <router-link to="/category-create" class="btn btn-primary">New Category</router-link>
              </div>
            </div>
          </div>
        </section>

        <!-- Main content -->
        <section class="content">
          <div class="container-fluid">
            <!-- Search Form -->
            <form @submit.prevent="searchCategories">
              <div class="card">
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
                <div class="card-body table-responsive p-0">
                  <table class="table table-hover text-nowrap" border="2">
                    <thead>
                      <tr>
                        <th>Product ID</th>
                        <th>Image</th>
                        <th>Product Name</th>
                        <th>Product Slug</th>
                        <th>Status</th>
                        <th>Action</th>
                      </tr>
                    </thead>
                    <tbody v-if="categories && categories.length > 0">
                      <tr v-for="category in categories" :key="category.id">
                        <td>{{ category.id }}</td>
                        <td><img width="100" :src="'/admin_assets/images/' + category.image" alt="" /></td>
                        <td>{{ category.name }}</td>
                        <td>{{ category.slug }}</td>
                        <td>
                          <svg v-if="category.status == 1" class="text-success h-6 w-6" fill="none" viewBox="0 0 24 24"
                            stroke-width="2" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round"
                              d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                          </svg>
                          <svg v-else class="text-danger h-6 w-6" fill="none" viewBox="0 0 24 24" stroke-width="2"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round"
                              d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                          </svg>
                        </td>
                        <td>
                          <router-link :to="'/category-update/' + category.id">
                            <svg class="w-4 h-4 mr-1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"
                              fill="currentColor" aria-hidden="true">
                              <path
                                d="M13.586 3.586a2 2 0 112.828 2.828l-.793.793-2.828-2.828.793-.793zM11.379 5.793L3 14.172V17h2.828l8.38-8.379-2.83-2.828z">
                              </path>
                            </svg>
                          </router-link>

                          <a href="#" @click.prevent="deleteCategory(category.id)" class="text-danger w-4 h-4 mr-1">
                            <svg class="w-4 h-4 mr-1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"
                              fill="currentColor" aria-hidden="true">
                              <path fill-rule="evenodd"
                                d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z"
                                clip-rule="evenodd"></path>
                            </svg>
                          </a>
                        </td>
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
            </form>
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
    AdminLayout,
  },
  data() {
    return {
      categories: { data: [] },
      pagination: "",
      searchKeyword: "",
      currentPage: 1,
    };
  },
  methods: {

    async fetchCategories() {
      try {
        let url = `http://127.0.0.1:8001/api/category-show?page=${this.currentPage}&keyword=${this.searchKeyword}`;
        let result = await axios.get(url);
        // Check the structure of the response
        console.log("Full response:", result);

        // Store the categories and pagination
        this.categories = result.data.categories;
        this.pagination = result.data.pagination;

      } catch (error) {
        console.error("Error fetching data:", error);
      }
    },

    searchCategories() {
      this.fetchCategories();
    },

    deleteCategory(id) {
      if (confirm("Do you really want to delete this record?")) {
        axios.delete(`http://127.0.0.1:8001/api/delete-category/${id}`)
          .then(() => {
            this.fetchCategories(this.currentPage); // Refresh the list after deletion
          })
          .catch((error) => {
            console.error(error);
          });
      }
    },

    goToPage(pageNumber) {
      this.currentPage = pageNumber;
      this.fetchCategories();
    }
  },

  mounted() {
        this.fetchCategories();
        if (this.$route.query.success) {
            this.successMessage = this.$route.query.success;
        }
    },
 
};
</script>

<style scoped>
/* Add your scoped styles here */
</style>
