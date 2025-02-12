<template>
      <AdminLayout>
        <template v-slot:content>
            <div class="content-wrapper">
        <section class="content-header">
            <div class="container-fluid my-2">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Create Product</h1>
                    </div>
                    <div class="col-sm-6 text-right">
                        <router-link to="/products" class="btn btn-primary">Back</router-link>
                    </div>
                </div>
            </div>
        </section>

        <section class="content">
            <form @submit.prevent="handleSubmit" id="ProductForm" name="ProductForm" enctype="multipart/form-data">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-md-8">
                            <div class="card mb-3">
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="mb-3">
                                                <label for="name">Name</label>
                                                <input type="text" v-model="product.name" class="form-control" placeholder="Product Name">
                                                <p v-if="errors.name" class="text-danger">{{ errors.name }}</p>
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="mb-3">
                                                <label for="slug">Slug</label>
                                                <input type="text" v-model="product.slug" class="form-control" placeholder="Slug">
                                                <p v-if="errors.slug" class="text-danger">{{ errors.slug }}</p>
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="mb-3">
                                                <label for="description">Description</label>
                                                <textarea v-model="product.description" id="description" cols="30" rows="10" class="form-control" placeholder="Description"></textarea>
                                                <p v-if="errors.description" class="text-danger">{{ errors.description }}</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="card mb-3">
                                <div class="card-body">
                                    <h2 class="h4 mb-3">Image</h2>
                                    <div id="image" class="dropzone dz-clickable">
                                        <div class="dz-message needsclick">
                                            <br>Drop Images Here or Click To Upload.<br><br>
                                        </div>
                                    </div>
                                    <p v-if="errors.image" class="text-danger">{{ errors.image }}</p>
                                </div>
                            </div>

                            <div class="card mb-3">
                                <div class="card-body">
                                    <h2 class="h4 mb-3">Pricing</h2>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="mb-3">
                                                <label for="price">Price</label>
                                                <input type="text" v-model="product.price" class="form-control" placeholder="Price">
                                                <p v-if="errors.price" class="text-danger">{{ errors.price }}</p>
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="mb-3">
                                                <label for="compare_price">Compare at Price</label>
                                                <input type="text" v-model="product.compare_price" class="form-control" placeholder="Compare Price">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="card mb-3">
                                <div class="card-body">
                                    <h2 class="h4 mb-3">Inventory</h2>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label for="sku">SKU (Stock Keeping Unit)</label>
                                                <input type="text" v-model="product.sku" class="form-control" placeholder="SKU">
                                                <p v-if="errors.sku" class="text-danger">{{ errors.sku }}</p>
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="mb-3">
                                                <div class="custom-control custom-checkbox">
                                                    <input class="custom-control-input" type="checkbox" v-model="product.track_qty">
                                                    <label for="track_qty" class="custom-control-label">Track Quantity</label>
                                                </div>
                                            </div>
                                            <div class="mb-3">
                                                <input type="number" v-model="product.qty" min="0" class="form-control" placeholder="Qty">
                                                <p v-if="errors.qty" class="text-danger">{{ errors.qty }}</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="card mb-3">
                                <div class="card-body">
                                    <h2 class="h4 mb-3">Product status</h2>
                                    <div class="mb-3">
                                        <select v-model="product.status" class="form-control">
                                            <option value="1">Active</option>
                                            <option value="0">Block</option>
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <div class="card">
                                <div class="card-body">
                                    <h2 class="h4 mb-3">Product category</h2>
                                    <div class="mb-3">
                                        <label for="category">Category</label>
                                        <select v-model="product.category" class="form-control">
                                            <option value="">---select---</option>
                                            <option v-for="(name, id) in categories" :key="id" :value="id">{{ name }}</option>
                                        </select>
                                        <p v-if="errors.category" class="text-danger">{{ errors.category }}</p>
                                    </div>
                                    <div class="mb-3">
                                        <label for="sub_category">Sub category</label>
                                        <select v-model="product.sub_category" class="form-control">
                                            <option value="">---select---</option>
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <div class="card mb-3">
                                <div class="card-body">
                                    <h2 class="h4 mb-3">Product brand</h2>
                                    <div class="mb-3">
                                        <select v-model="product.brand" class="form-control">
                                            <option value="">---select---</option>
                                            <option v-for="(name, id) in brands" :key="id" :value="id">{{ name }}</option>
                                        </select>
                                        <p v-if="errors.brand" class="text-danger">{{ errors.brand }}</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="pb-5 pt-3">
                        <button type="submit" class="btn btn-primary">Create</button>
                        <button type="reset" @click="handleReset">Cancel</button>
                    </div>
                </div>
            </form>
        </section>
    </div>
  </template>
   </AdminLayout>
</template>
  
  <script>
  import Dropzone from "vue2-dropzone";
import AdminLayout from '../../admin/Layouts/AdminLayout.vue';

  import "vue2-dropzone/dist/vue2Dropzone.min.css";
  
  export default {
    components: {
      Dropzone,
      AdminLayout

    },
    data() {
      return {
        product: {
          name: '',
          slug: '',
          description: '',
          price: '',
          compare_price: '',
          sku: '',
          qty: '',
          status: 1,
          category: '',
          brand: '',
          image: null,
        },
        errors: {},
        categories: {}, // Categories fetched from the server
        brands: {}, // Brands fetched from the server
      };
    },
    methods: {
      submitProductForm() {
        this.$axios.post('/admin/products', this.product)
          .then(response => {
            // Handle success
            this.$router.push('/admin/product');
          })
          .catch(error => {
            // Handle validation errors
            this.errors = error.response.data.errors;
          });
      },
      onFilesAdded(files) {
        this.product.image = files; // Handle added files here
      },
      onFileRemoved(file) {
        // Handle file removal
      },
      resetForm() {
        this.product = {
          name: '',
          slug: '',
          description: '',
          price: '',
          compare_price: '',
          sku: '',
          qty: '',
          status: 1,
          category: '',
          brand: '',
          image: null,
        };
      },
    },
    mounted() {
      // Fetch categories and brands here
      this.$axios.get('/api/categories').then(response => {
        this.categories = response.data;
      });
      this.$axios.get('/api/brands').then(response => {
        this.brands = response.data;
      });
    },
  };
  </script>
  
  <style scoped>
  /* Add any scoped styles if necessary */
  </style>
  