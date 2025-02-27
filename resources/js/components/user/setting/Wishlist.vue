<template>
    <Header/>
    <main>
      <section class="section-5 pt-3 pb-3 mb-3 bg-white">
        <div class="container">
          <div class="light-font">
            <ol class="breadcrumb primary-color mb-0">
              <li class="breadcrumb-item">
                <router-link to="/shop" class="white-text">Shop</router-link>
              </li>
              <li class="breadcrumb-item">
                <span class="white-text">My Account</span>
              </li>
              <li class="breadcrumb-item">Settings</li>
            </ol>
          </div>
        </div>
      </section>
  
      <section class="section-11">
        <div class="container mt-5">
          <div class="row">
            <div class="col-md-3">
              <SettingSideBar />
            </div>
            <div class="col-md-9">
              <div v-if="statusMessage" class="alert alert-success">
                {{ statusMessage }}
              </div>
  
              <div class="card">
                <div class="card-header">
                  <h2 class="h5 mb-0 pt-2 pb-2">My Wishlist</h2>
                </div>
  
                <div v-if="wishlist.length > 0">
                  <div
                    v-for="item in wishlist"
                    :key="item.id"
                    class="card-body p-4"
                  >
                    <div
                      class="d-sm-flex justify-content-between mt-lg-4 mb-4 pb-3 pb-sm-2 border-bottom"
                    >
                      <div
                        class="d-block d-sm-flex align-items-start text-center text-sm-start"
                      >
                        <router-link
                          :to="'/product/' + item.slug"
                          class="d-block flex-shrink-0 mx-auto me-sm-4"
                          style="width: 10rem"
                        >
                          <img
                            width="120"
                            height="120"
                            class="cardimgtop"
                            :src="getProductImage(item)"
                            alt="Product Image"
                          />
                        </router-link>
                        <div class="pt-2">
                          <h3 class="product-title fs-base mb-2">
                            <router-link
                              class="text-dark"
                              :to="'/product/' + item.slug"
                            >
                              {{ item.prod_name }}
                            </router-link>
                          </h3>
                          <div class="fs-lg text-accent pt-2">
                            <i class="fa fa-inr" aria-hidden="true">
                              {{ item.price }}
                            </i>
                          </div>
                        </div>
                      </div>
  
                      <div class="pt-2 ps-sm-3 mx-auto mx-sm-0 text-center">
                        <button
                          @click="moveToCart(item)"
                          class="btn btn-outline-success btn-sm"
                        >
                          Add To Cart
                        </button>
                        <button
                          @click="removeFromWishlist(item.wid)"
                          class="btn btn-outline-danger btn-sm"
                        >
                          <i class="fas fa-trash-alt me-2"></i> Remove
                        </button>
                      </div>
                    </div>
                  </div>
                </div>
  
                <div v-else class="row">
                  <div class="col-md-12 text-center pt-5 bp-5">
                    <p>No items found in your wishlist</p>
                    <router-link to="/shop" class="btn btn-info">Shop Now</router-link>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </section>
    </main>
  </template>
  
  <script>
  import axios from "axios";
  import SettingSideBar from "./SettingSideBar.vue";
  import Header from "../include/Header.vue";

//   import AccountPanel from "@/components/AccountPanel.vue"; // Import Account Panel
  
  export default {
    components: { SettingSideBar,Header },
    
    data() {
      return {
        wishlist: [],
        statusMessage: ""
      };
    },
  
    methods: {
      async fetchWishlist() {
        try {
          const response = await axios.get("/api/wishlist");
          this.wishlist = response.data.product;
          console.log(this.wishlist)
        } catch (error) {
          console.error("Error fetching wishlist:", error);
        }
      },
  
      async moveToCart(item) {
        try {
          await axios.post("/api/move-to-cart", {
            prod_id: item.id,
            user_id: 1, // Replace with actual user ID
            qty: 1
          });
          this.statusMessage = "Item moved to cart!";
          this.fetchWishlist();
        } catch (error) {
          console.error("Error moving to cart:", error);
        }
      },
  
      async removeFromWishlist(id) {
        try {
          await axios.delete(`/api/remove-wishlist/${id}`);
          this.statusMessage = "Item removed from wishlist!";
          this.fetchWishlist();
        } catch (error) {
          console.error("Error removing item:", error);
        }
      },
  
      getProductImage(item) {
        return item.images
          ? `/admin_assets/images/${item.images}`
          : `/admin_assets/images/${item.image}`;
      }
    },
  
    mounted() {
      this.fetchWishlist();
    }
  };
  </script>
  
  <style scoped>
  /* Add custom styles if needed */
  </style>
  