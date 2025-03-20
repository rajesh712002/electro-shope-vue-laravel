<template>
  <Header></Header>
  <main>


    <section class="section-1">
      <div id="carouselExampleIndicators" class="carousel slide carousel-fade" data-bs-ride="carousel"
        data-bs-interval="3000">
        <div class="carousel-inner">
          <div v-for="(banner, index) in banners" :key="banner.id" :class="['carousel-item', { active: index === 0 }]">
            <img :src="'/admin_assets/images/' + banner.image" class="d-block w-100" alt="Banner Image">
            <div class="carousel-caption d-none d-md-block">
              <h1 class="display-4 text-white mb-3 ">{{ banner.title }}</h1>
              <p class="mx-md-5 px-5" v-html="banner.description"></p>
            </div>
          </div>
        </div>
        <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleIndicators"
          data-bs-slide="prev">
          <span class="carousel-control-prev-icon" aria-hidden="true"></span>
          <span class="visually-hidden">Previous</span>
        </button>
        <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleIndicators"
          data-bs-slide="next">
          <span class="carousel-control-next-icon" aria-hidden="true"></span>
          <span class="visually-hidden">Next</span>
        </button>
      </div>
    </section>


    <section class="section-2">
      <div class="container">
        <div class="row">
          <div class="col-3" v-for="(feature, index) in features" :key="index">
            <div class="box shadow">
              <div :class="['fa', 'icon', feature.icon, 'text-primary', 'm-0', 'mr-3']"></div>
              <h2 class="font-weight-semi-bold m-0">{{ feature.text }}</h2>
            </div>
          </div>
        </div>
      </div>
    </section>

    <section class="section-3">
      <div class="container">
        <div class="section-title">
          <h2>Categories</h2>
        </div>
        <div class="row pb-3">
          <div class="col-lg-3" v-for="category in categories" :key="category.id">
            <div class="cat-card">
              <router-link :to="'/shop'">
                <div class="left">
                  <img class="imgfluid" :src="'/admin_assets/images/' + category.image" alt="Category Image"
                    style="width: 100px; height: 100px; object-fit:contain;">
                </div>
              </router-link>
              <div class="right">
                <router-link :to="'/shop/'">
                  <div class="cat-data">
                    <h2><b>{{ category.name }}</b></h2>
                    <p><b>{{ category.product_count }} Products</b></p>
                  </div>
                </router-link>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>

    <section class="section-4 pt-5">
      <div class="container">
        <div class="section-title">
          <h2>Latest Products</h2>
        </div>
        <div class="row pb-3">
          <div class="col-md-3" v-for="product in products" :key="product.id">
            <div class="card product-card">
              <div class="product-image position-relative">
                <router-link :to="'/view-product/' + product.slug">
                  <img class="cardimgtop" :src="product.product_images && product.product_images.length > 0
                    ? '/admin_assets/images/' + product.product_images[0].images
                    : (product.image ? '/admin_assets/images/' + product.image : '')" alt="Product Image"
                    style="width: 200px; height: 200px; object-fit: contain;">
                </router-link>

                <div class="product-action">
                  <button @click="addToCart(product)" class="btn btn-dark">
                    <i class="fas fa-shopping-cart"></i> Add To Cart
                  </button>
                </div>
              </div>
              <div class="card-body text-center mt-3">
                <router-link class="h6 link" :to="'/view-product/' + product.slug">{{ product.prod_name }}</router-link>
                <div class="price mt-2">
                  <span class="h5"><strong><i class="fa fa-inr" aria-hidden="true"></i> {{ product.price
                  }}</strong></span>
                  <span class="h6 text-underline"><del>{{ product.compare_price }}</del></span>
                </div>
                <div class="text-secondary"> InStock: {{ product.qty }}</div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>
  </main>
</template>

<script>
import axios from 'axios';
import Header from './include/Header.vue';
import { useAuthStore } from "../../stores/auth"; 
import { useGuestCartStore } from "../../stores/guestCart"; 

export default {
  components: {
    Header
  },
  data() {
    return {
      categories: [],
      banners: [],
      products: [],
      features: [
        { icon: 'fa-check', text: 'Quality Product' },
        { icon: 'fa-shipping-fast', text: 'Free Shipping' },
        { icon: 'fa-exchange-alt', text: '14-Day Return' },
        { icon: 'fa-phone-volume', text: '24/7 Support' }
      ],
      authStore: useAuthStore(),
      
    };
  },
  mounted() {

    this.fetchCategories();
    this.fetchProducts();
    this.fetchBanners();
  },
  methods: {
    async fetchBanners() {
      try {
        const response = await axios.get('/api/banners');
        console.log('banners', response);
        this.banners = response.data.banners;
      } catch (error) {
        console.error('Error fetching banners:', error);
      }
    },
    async fetchCategories() {
      try {
        const response = await axios.get('/api/get-category');
        this.categories = response.data.category;
      } catch (error) {
        console.error('Error fetching categories:', error);
      }
    },
    async fetchProducts() {
      try {
        const response = await axios.get('/api/get-product');
        this.products = response.data.product;
        console.log(response)
      } catch (error) {
        console.error('Error fetching products:', error);
      }
    },
    // async addToCart(product) {
    //   console.log('Adding to cart:', product);
    //   try {
    //     const response = await axios.post('/api/add-cart', {
    //       prod_id: product.id,
    //       user_id: 7,  
    //       qty: 1, 
    //       price: product.price,
    //       name: product.prod_name,
    //       image: product.image || (product.product_images?.length > 0 ? product.product_images[0].images : ''),
    //       max_qty: product.qty 
    //     });

    //     console.log(response.data);
    //   } catch (error) {
    //     console.error('Error adding to cart:', error);
    //   }
    // },

    async addToCart(product) {
      // const authStore = useAuthStore(); // Get Auth Store
      const guestCartStore = useGuestCartStore(); // Get Guest Cart Store

      console.log('Adding to cart:', product);

      if (this.authStore.isAuthenticated) {
        try {
          const response = await axios.post('/api/add-cart', {
            prod_id: product.id,
            // user_id: this.authStore.userId, // Get logged-in user ID
            qty: 1,
            price: product.price,
            name: product.prod_name,
            image: product.image || (product.product_images?.length > 0 ? product.product_images[0].images : ''),
            max_qty: product.qty
          }, {
            headers: { Authorization: `Bearer ${this.authStore.token}` }
          });

          console.log(response.data);
        } catch (error) {
          console.error('Error adding to cart:', error);
        }
      } else {
        guestCartStore.addToCart(product);
        console.log('Added to guest cart:', guestCartStore.cart);
      }
    },
    // async fetchUser() {
    //   try {
    //     let response = await axios.get("/api/valid-user", {
    //       withCredentials: true,
    //       headers: {
    //         'X-Requested-With': 'XMLHttpRequest'
    //       }
    //     });
    //     console.log('user', response.data.user); // Returns logged-in user
    //   } catch (error) {
    //     console.error("User not authenticated", error);
    //   }
    // }

  }
};
</script>
