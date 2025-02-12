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
                        <a :href="item.link" class="small-box-footer text-dark">More info
                          <i class="fas fa-arrow-circle-right"></i></a>
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
export default {
  components: {
    AdminLayout
  },

  data() {
    return {
      // Replace this with actual dynamic data fetching
      dashboardData: [
        {
          count: 10,
          title: 'Categories',
          iconClass: 'fa fa-th-large f-s-40',
          link: '/admin/category',
        },
        {
          count: 20,
          title: 'Sub Categories',
          iconClass: 'fa fa-qrcode f-s-40',
          link: '/admin/subcategory',
        },
        {
          count: 30,
          title: 'Products',
          iconClass: 'fa fa-home f-s-40',
          link: '/admin/product',
        },
        {
          iconClass: 'fa fa-window-maximize f-s-40',
          count:7,// this.totalbrand,
          title: 'Total Brands',
          link: '',
        },
        {
          iconClass: 'fa fa-users f-s-40',
          count:7,// this.totaluser,
          title: 'Users',
          link: '',
        },
        {
          iconClass: 'fa fa-shopping-cart f-s-40',
          count:7,// this.totalorder,
          title: 'Total Orders',
          link: '',
        },
        {
          iconClass: 'fa fa-genderless f-s-70',
          count:7,// this.statusCounts['pending'] ?? 0,
          title: 'Pending Orders',
          link: '',
        },
        {
          iconClass: 'fa fa-spinner f-s-40',
          count:7, // (this.statusCounts['shipped'] ?? 0) + (this.statusCounts['out for delivery'] ?? 0),
          title: 'Processing Orders',
          link: '',
        },
        {
          iconClass: 'fa fa-check f-s-40',
          count:7,// this.statusCounts['delivered'] ?? 0,
          title: 'Delivered Orders',
          link: '',
        },
        {
          iconClass: 'fa fa-times f-s-40',
          count:7,// this.statusCounts['cancelled'] ?? 0,
          title: 'Cancelled Orders',
          link: '',
        },
        {
          iconClass: 'fa fa-coins f-s-40',
          count:7,// this.statusCounts['refunded'] ?? 0,
          title: 'Refunded Orders',
          link: '',
        },
        {
          iconClass: 'fa fa-inr f-s-40',
          count:7,// this.totalearning,
          title: 'Total Earnings',
          link: '#',
        },
        // Add other cards similarly
      ],
      
    };
    
  },
  mounted() {
    // Example: fetch data for dashboard if needed
    // axios.get('/api/dashboard-data').then(response => {
    //   this.dashboardData = response.data;
    // });
  },
  props: {
    totalbrand: {
      type: Number,
      required: true,
    },
    totaluser: {
      type: Number,
      required: true,
    },
    totalorder: {
      type: Number,
      required: true,
    },
    statusCounts: {
      type: Object,
      required: true,
    },
    totalearning: {
      type: Number,
      required: true,
    },
  },
};
</script>

<style scoped>
/* Add any custom styles for the dashboard */
</style>
