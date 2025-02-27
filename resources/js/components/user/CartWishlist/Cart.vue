<template>
  <Header />
    <main>
      <section class="section-5 pt-3 pb-3 mb-3 bg-white">
        <div class="container">
          <div class="light-font">
            <ol class="breadcrumb primary-color mb-0">
              <li class="breadcrumb-item"><router-link class="white-text" to="/">Home</router-link></li>
              <li class="breadcrumb-item"><router-link class="white-text" to="/shop">Shop</router-link></li>
              <li class="breadcrumb-item">Cart</li>
            </ol>
          </div>
        </div>
      </section>
  
      <section class="section-9 pt-4">
        <div class="container">
          <div class="row">
            <div class="col-md-8">
              <div v-if="cart.length > 0" class="table-responsive">
                <table class="table" id="cart">
                  <thead>
                    <tr>
                      <th>Image</th>
                      <th>Item</th>
                      <th>Price</th>
                      <th>Quantity</th>
                      <th>Total</th>
                      <th>Remove</th>
                    </tr>
                  </thead>
                  <tbody>
                    <tr v-for="item in cart" :key="item.cid">
                      <td>
                        <router-link :to="'/product/' + item.slug">
                          <img :src="getImage(item)" width="120" height="120" class="cardimgtop" alt="Product Image" />
                        </router-link>
                      </td>
                      <td>{{ item.prod_name }}</td>
                      <td>{{ item.price }}</td>
                      <td>
                        <div class="input-group quantity mx-auto" style="width: 100px;">
                          <button class="btn btn-sm btn-dark btn-minus" @click="updateQuantity(item.cid, 'decrease')">
                            <i class="fa fa-minus"></i>
                          </button>
                          <input type="text" class="form-control form-control-sm border-0 text-center" v-model="item.cqty" readonly />
                          <button class="btn btn-sm btn-dark btn-plus" @click="updateQuantity(item.cid, 'increase')">
                            <i class="fa fa-plus"></i>
                          </button>
                        </div>
                      </td>
                      <td>{{ item.price * item.cqty }}</td>
                      <td>
                        <button class="btn btn-sm btn-danger" @click="removeItem(item.cid)">
                          <i class="fa fa-times"></i>
                        </button>
                      </td>
                    </tr>
                  </tbody>
                </table>
              </div>
              <div v-else class="text-center pt-5">
                <p>No items found in your cart</p>
                <router-link to="/shop" class="btn btn-info">Shop Now</router-link>
              </div>
            </div>
  
            <div class="col-md-4" v-if="cart.length > 0">
              <div class="card cart-summary">
                <div class="sub-title">
                  <h2 class="bg-white">Cart Summary</h2>
                </div>
                <div class="card-body">
                  <div class="d-flex justify-content-between pb-2">
                    <div>Subtotal</div>
                    <div>{{ totalSum }}</div>
                  </div>
                  <div class="d-flex justify-content-between pb-2">
                    <div>Discount</div>
                    <div>{{ discount }}</div>
                  </div>
                  <div class="d-flex justify-content-between pb-2">
                    <div>Shipping</div>
                    <div>Free</div>
                  </div>
                  <br>
                  <div class="input-group apply-coupon mt-4">
                    <input type="text" placeholder="Coupon Code" class="form-control" v-model="couponCode">
                    <button class="btn btn-dark" @click="applyCoupon">Apply Coupon</button>
                  </div>
                  <button class="btn btn-danger btn-sm mt-2" v-if="couponCode" @click="removeCoupon">Remove Coupon</button>
                  <br><br>
                  <div class="d-flex justify-content-between summary-end">
                    <div>Total</div>
                    <div>{{ newTotal }}</div>
                  </div>
                  <div class="pt-5">
                    <router-link to="/checkout" class="btn btn-dark w-100">Proceed to Checkout</router-link>
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
  import Header from "../include/Header.vue";

  export default {
    components: {
      Header,
    },
    data() {
      return {
        cart: [], // Fetch from API or Vuex
        couponCode: '',
        discount: 0,
      };
    },
    computed: {
      totalSum() {
        return this.cart.reduce((sum, item) => sum + item.price * item.cqty, 0);
      },
      newTotal() {
        return this.totalSum - this.discount;
      }
    },
    methods: {
      getImage(item) {
        return item.images ? `/admin_assets/images/${item.images}` : `/admin_assets/images/${item.image}`;
      },
      updateQuantity(cid, action) {
        const item = this.cart.find(p => p.cid === cid);
        if (item) {
          if (action === 'increase') item.cqty++;
          else if (action === 'decrease' && item.cqty > 1) item.cqty--;
        }
      },
      removeItem(cid) {
        this.cart = this.cart.filter(item => item.cid !== cid);
      },
      applyCoupon() {
        // Fetch coupon discount from API
        this.discount = 10; // Example
      },
      removeCoupon() {
        this.couponCode = '';
        this.discount = 0;
      }
    },
    created() {
      // Fetch cart items from API or localStorage
      this.cart = [
        { cid: 1, prod_name: 'Product 1', price: 100, cqty: 2, image: 'default.jpg', slug: 'product-1' },
        { cid: 2, prod_name: 'Product 2', price: 200, cqty: 1, image: 'product2.jpg', slug: 'product-2' }
      ];
    }
  };
  </script>
  
  <style scoped>
  .cart-summary {
    padding: 20px;
    background: #fff;
    border-radius: 10px;
    box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
  }
  </style>
  