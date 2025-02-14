<template>
  <AdminLayout>
    <template v-slot:content>
      <div>
        <!-- Content Header (Page header) -->
        <section class="content-header">
          <div class="container-fluid">
            <div class="row mb-2">
              <div class="col-sm-6">
                <h1>Dashboard</h1>
              </div>
              <div class="col-sm-6"></div>
            </div>
          </div>
        </section>

        <div id="main-wrapper">
          <div class="page-wrapper">
            <div class="container-fluid">
              <div class="col-lg-12">
                <div class="card card-outline-primary">
                  <div class="card-header">
                    <h4 class="m-b-0 text-white">Admin Dashboard</h4>
                  </div>
                  <div class="row">
                    <!-- Loop over each card item -->
                    <div v-for="(item, index) in dashboardData" :key="index" class="col-md-4">
                      <div class="card p-30">
                        <div class="media">
                          <div class="media-left meida media-middle">
                            <span><i :class="item.iconClass" aria-hidden="true"></i></span>
                          </div>
                          <div class="media-body media-text-right">
                            <b>{{ item.count }}</b>
                            <p class="m-b-0">{{ item.title }}</p>
                          </div>
                        </div>
                        <router-link v-if="item.link" :to="item.link" class="small-box-footer text-dark">
                          More info <i class="fas fa-arrow-circle-right"></i>
                        </router-link>

                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </template>
  </AdminLayout>
</template>

<script>
import AdminLayout from '../admin/Layouts/AdminLayout.vue';
import axios from "axios";
import '@css/admin_assets/css/css/helper.css';
import '@css/admin_assets/css/adminlte.min.css';
import '@css/admin_assets/css/css/style.css';
// export default {
//   components: {
//     AdminLayout
//   },

//   data() {
//     return {
//       // Replace this with actual dynamic data fetching
//       dashboardData: [
//         {
//           count: 10,
//           title: 'Categories',
//           iconClass: 'fa fa-th-large f-s-40',
//           link: '/admin/category',
//         },
//         {
//           count: 20,
//           title: 'Sub Categories',
//           iconClass: 'fa fa-qrcode f-s-40',
//           link: '/admin/subcategory',
//         },
//         {
//           count: 30,
//           title: 'Products',
//           iconClass: 'fa fa-home f-s-40',
//           link: '/admin/product',
//         },
//         {
//           iconClass: 'fa fa-window-maximize f-s-40',
//           count:7,// this.totalbrand,
//           title: 'Total Brands',
//           link: '',
//         },
//         {
//           iconClass: 'fa fa-users f-s-40',
//           count:7,// this.totaluser,
//           title: 'Users',
//           link: '',
//         },
//         {
//           iconClass: 'fa fa-shopping-cart f-s-40',
//           count:7,// this.totalorder,
//           title: 'Total Orders',
//           link: '',
//         },
//         {
//           iconClass: 'fa fa-genderless f-s-70',
//           count:7,// this.statusCounts['pending'] ?? 0,
//           title: 'Pending Orders',
//           link: '',
//         },
//         {
//           iconClass: 'fa fa-spinner f-s-40',
//           count:7, // (this.statusCounts['shipped'] ?? 0) + (this.statusCounts['out for delivery'] ?? 0),
//           title: 'Processing Orders',
//           link: '',
//         },
//         {
//           iconClass: 'fa fa-check f-s-40',
//           count:7,// this.statusCounts['delivered'] ?? 0,
//           title: 'Delivered Orders',
//           link: '',
//         },
//         {
//           iconClass: 'fa fa-times f-s-40',
//           count:7,// this.statusCounts['cancelled'] ?? 0,
//           title: 'Cancelled Orders',
//           link: '',
//         },
//         {
//           iconClass: 'fa fa-coins f-s-40',
//           count:7,// this.statusCounts['refunded'] ?? 0,
//           title: 'Refunded Orders',
//           link: '',
//         },
//         {
//           iconClass: 'fa fa-inr f-s-40',
//           count:7,// this.totalearning,
//           title: 'Total Earnings',
//           link: '#',
//         },
//         // Add other cards similarly
//       ],

//     };

//   },
//   mounted() {
//     // Example: fetch data for dashboard if needed
//     // axios.get('/api/dashboard-data').then(response => {
//     //   this.dashboardData = response.data;
//     // });
//   },
//   props: {
//     totalbrand: {
//       type: Number,
//       required: true,
//     },
//     totaluser: {
//       type: Number,
//       required: true,
//     },
//     totalorder: {
//       type: Number,
//       required: true,
//     },
//     statusCounts: {
//       type: Object,
//       required: true,
//     },
//     totalearning: {
//       type: Number,
//       required: true,
//     },
//   },
// };

export default {
  components: {
    AdminLayout
  },

  data() {
    return {
      dashboardData: [],
      totalUser: 0,
      totalCategory: 0,
      totalSubcategory: 0,
      totalBrand: 0,
      totalProduct: 0,
      totalEarning: 0,
      totalOrder: 0,
      statusCounts: {}
    };
  },

  mounted() {
    this.fetchDashboardData();
  },

  methods: {
    async fetchDashboardData() {
      try {
        const response = await axios.get('/api/deshboard');
        const data = response.data;

        this.totalUser = data.totalUser;
        this.totalCategory = data.totalCategory;
        this.totalSubcategory = data.totalSubcategory;
        this.totalBrand = data.totalBrand;
        this.totalProduct = data.totalProduct;
        this.totalEarning = data.totalEarning;
        this.totalOrder = data.totalOrder;
        this.statusCounts = data.statusCounts;

        this.dashboardData = [
          { count: this.totalCategory, title: 'Categories', iconClass: 'fa fa-th-large f-s-40', link: '/categories' },
          { count: this.totalSubcategory, title: 'Sub Categories', iconClass: 'fa fa-qrcode f-s-40', link: '/subcategories' },
          { count: this.totalProduct, title: 'Products', iconClass: 'fa fa-home f-s-40', link: '/products' },
          { count: this.totalBrand, title: 'Total Brands', iconClass: 'fa fa-window-maximize f-s-40', link: '/brands' },
          { count: this.totalUser, title: 'Users', iconClass: 'fa fa-users f-s-40', link: '/users' },
          { count: this.totalOrder, title: 'Total Orders', iconClass: 'fa fa-shopping-cart f-s-40', link: '/orders' },
          { count: this.statusCounts['pending'] ?? 0, title: 'Pending Orders', iconClass: 'fa fa-genderless f-s-70', link: '/orders' },
          { count: (this.statusCounts['shipped'] ?? 0) + (this.statusCounts['out for delivery'] ?? 0), title: 'Processing Orders', iconClass: 'fa fa-spinner f-s-40', link: '/orders' },
          { count: this.statusCounts['delivered'] ?? 0, title: 'Delivered Orders', iconClass: 'fa fa-check f-s-40', link: '/orders' },
          { count: this.statusCounts['cancelled'] ?? 0, title: 'Cancelled Orders', iconClass: 'fa fa-times f-s-40', link: '/orders' },
          { count: this.statusCounts['refunded'] ?? 0, title: 'Refunded Orders', iconClass: 'fa fa-coins f-s-40', link: '/orders' },
          { count: this.totalEarning, title: 'Total Earnings', iconClass: 'fa fa-inr f-s-40', link: '/orders' },
        ];
      } catch (error) {
        console.error("Error fetching dashboard data", error);
      }
    }
  }
};
</script>

<style scoped>
/* Add any custom styles for the dashboard */
</style>
