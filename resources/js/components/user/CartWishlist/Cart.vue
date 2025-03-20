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
                  <tr v-for="item in (isGuest ? guestCartItems : cart)" :key="item.prod_id">
                    <td>
                      <router-link :to="'/view-product/' + item.slug">
                        <img :src="getImage(item)" width="120" height="120" class="cardimgtop" alt="Product Image" />
                      </router-link>
                    </td>
                    <td>{{ isGuest ? item.name : item.prod_name }}</td>
                    <td>{{ item.price }}</td>
                    <td>
                      <div class="input-group quantity mx-auto" style="width: 100px;">
                        <button type="button" class="btn btn-sm btn-dark btn-minus px-2 py-1"
                          @click="updateQuantity(isGuest ? item.prod_id : item.cid, 'decrease')">
                          <i class="fa fa-minus"></i>
                        </button>
                        <input v-if="isGuest" type="text" class="form-control form-control-sm border-0 text-center"
                          v-model="item.qty" readonly>
                        <input type="text" class="form-control form-control-sm border-0 text-center" v-model="item.cqty"
                          readonly>
                        <button type="button" class="btn btn-sm btn-dark btn-plus px-2 py-1"
                          @click="updateQuantity(isGuest ? item.prod_id : item.cid, 'increase')">
                          <i class="fa fa-plus"></i>
                        </button>
                      </div>
                    </td>
                    <td v-if="isGuest">{{ item.price * (isGuest ? item.qty : item.cqty) }}</td>
                    <!-- <td>{{ item.price * item.cqty }}</td> -->

                    <td>
                      <button class="btn btn-sm btn-danger" @click="removeItem(isGuest ? item.prod_id : item.cid)">
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
                <div class="d-flex justify-content-between summary-end">
                  <div>Total</div>
                  <div>{{ isGuest ? guestTotalPrice : totalPrice }}</div>
                </div>

                <div class="d-flex justify-content-between pb-2">
                  <div>Discount</div>
                  <div>{{ discountAmount }}</div>
                </div>

                <div class="d-flex justify-content-between pb-2">
                  <div>Shipping</div>
                  <div>Free</div>
                </div>
                <br>
                <div v-if="!isGuest">
                  <div class="input-group apply-coupon mt-4">
                    <input type="text" placeholder="Coupon Code" class="form-control" v-model="couponCode">
                    <button class="btn btn-dark" @click="applyCoupon">Apply Coupon</button>
                  </div>
                  <button class="btn btn-danger btn-sm mt-2" v-if="couponCode" @click="removeCoupon">Remove
                    Coupon</button>
                </div>

                <br><br>
                <div class="d-flex justify-content-between summary-end">
                  <div>Total</div>
                  <div>{{ isGuest ? guestTotalPrice : totalPrice }}</div>
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
import axios from "axios";
import { useAuthStore } from "../../../stores/auth";
import { useCartStore } from "../../../stores/cartStore";
import { useGuestCartStore } from "../../../stores/guestCart";
// const authStore = useAuthStore(); // 
export default {
  components: {
    Header,
  },
  data() {
    return {
      authStore: useAuthStore(),
      cartStore: useCartStore(),
      guestCartStore: useGuestCartStore(),
      cart: [],
      totalSum: 0,
      couponCode: '',
      discount: 0,
      newTotal: 0,
    };
  },
  computed: {
    newTotalAmount() {
      return this.totalSum - this.discount;
    }
  },

  // methods: {
  //   async fetchCartData() {
  //     if (this.isGuest) {

  //       this.cart = this.guestCartStore.cart;
  //       this.totalSum = this.guestCartStore.cartTotal;
  //     }
  //     else {
  //       try {
  //         const response = await axios.get("/api/cart", {
  //           headers: { Authorization: `Bearer ${this.authStore.token}` }
  //         });
  //         const data = response.data;
  //         console.log(response)
  //         this.cart = data.product;
  //         this.totalSum = data.totalSum;
  //         this.couponCode = data.couponCode || '';
  //         this.discount = data.discount;
  //         this.newTotal = data.newTotal;
  //       } catch (error) {
  //         console.error("Error fetching cart data:", error);
  //       }
  //     }
  //   },
  //   getImage(item) {
  //     return item.images ? `/admin_assets/images/${item.images}` : `/admin_assets/images/${item.image}`;
  //   },
  //   async updateQuantity(rowId, action) {
  //     try {
  //       if (action === "increase") {
  //         await axios.put(`/api/cart/increase/${rowId}`);
  //       } else if (action === "decrease") {
  //         await axios.put(`/api/cart/decrease/${rowId}`);
  //       }
  //       this.fetchCartData();
  //     } catch (error) {
  //       console.error("Error updating quantity:", error);
  //     }
  //   },
  //   async removeItem(rowId) {
  //     try {
  //       await axios.delete(`/api/cart/remove_item/${rowId}`);
  //       this.fetchCartData();
  //     } catch (error) {
  //       console.error("Error removing item:", error);
  //     }
  //   },
  //   async applyCoupon() {
  //     try {

  //       const response = await axios.post("/api/apply_coupon", {
  //         coupon_code: this.couponCode,
  //       }, {
  //         headers: { Authorization: `Bearer ${this.authStore.token}` }
  //       });
  //       console.log('auth', response)
  //       const data = response.data;

  //       if (data.success) {

  //         this.cartStore.setCoupon(this.couponCode, data.discountAmount, data.newTotal);
  //         // this.fetchCartData();

  //       } else {
  //         alert(data.message);
  //       }
  //     } catch (error) {
  //       console.error("Error applying coupon:", error);
  //       alert("An error occurred while applying the coupon.");
  //     }
  //   },
  //   async removeCoupon() {
  //     try {
  //       await axios.post("/api/remove_coupon", {}, {
  //         headers: { Authorization: `Bearer ${this.authStore.token}` }
  //       });

  //       this.cartStore.clearCoupon();
  //       this.fetchCartData();

  //     } catch (error) {
  //       console.error("Error removing coupon:", error);
  //       alert("An error occurred while removing the coupon.");
  //     }
  //   },


  //   async getCoupons() {
  //     try {
  //       const response = await axios.get("/api/get_coupons");
  //       console.log(response.data);
  //     } catch (error) {
  //       console.error("Error fetching coupons:", error);
  //     }
  //   }
  // },
  // created() {
  //   this.fetchCartData();
  // },


  methods: {
    async fetchCartData() {
      if (this.isGuest) {
        // Guest User: Load from Local Storage
        this.cart = this.guestCartStore.cart;
        this.totalSum = this.guestCartStore.cartTotal;
      } else {
        // Authenticated User: Load from API
        try {
          const response = await axios.get("/api/cart", {
            headers: { Authorization: `Bearer ${this.authStore.token}` }
          });
          console.log(response.data.product);
          const data = response.data;
          this.cart = data.product;
          this.totalSum = data.totalSum;
          this.couponCode = data.couponCode || '';
          this.discount = data.discount;
          this.newTotal = data.newTotal;
        } catch (error) {
          console.error("Error fetching cart data:", error);
        }
      }
    },
    getImage(item) {
      return item.images ? `/admin_assets/images/${item.images}` : `/admin_assets/images/${item.image}`;
    },
    updateQuantity(productId, action) {
      if (this.isGuest) {
        this.guestCartStore.updateCartItem(productId, action);
      } else {
        this.updateQuantityAPI(productId, action);
      }
    },
    removeItem(productId) {
      if (this.isGuest) {
        this.guestCartStore.removeFromCart(productId);
      } else {
        this.removeItemAPI(productId);
      }
    },
    async updateQuantityAPI(rowId, action) {
      try {
        if (action === "increase") {
          await axios.put(`/api/cart/increase/${rowId}`);
        } else if (action === "decrease") {
          await axios.put(`/api/cart/decrease/${rowId}`);
        }
        this.fetchCartData();
      } catch (error) {
        console.error("Error updating quantity:", error);
      }
    },
    async removeItemAPI(rowId) {
      try {
        await axios.delete(`/api/cart/remove_item/${rowId}`);
        this.fetchCartData();
      } catch (error) {
        console.error("Error removing item:", error);
      }
    },


    async applyCoupon() {
      try {

        const response = await axios.post("/api/apply_coupon", {
          coupon_code: this.couponCode,
        }, {
          headers: { Authorization: `Bearer ${this.authStore.token}` }
        });
        console.log('auth', response)
        const data = response.data;

        if (data.success) {

          this.cartStore.setCoupon(this.couponCode, data.discountAmount, data.newTotal);
          // this.fetchCartData();

        } else {
          alert(data.message);
        }
      } catch (error) {
        console.error("Error applying coupon:", error);
        alert("An error occurred while applying the coupon.");
      }
    },
    async removeCoupon() {
      try {
        await axios.post("/api/remove_coupon", {}, {
          headers: { Authorization: `Bearer ${this.authStore.token}` }
        });

        this.cartStore.clearCoupon();
        this.fetchCartData();

      } catch (error) {
        console.error("Error removing coupon:", error);
        alert("An error occurred while removing the coupon.");
      }
    },


    async getCoupons() {
      try {
        const response = await axios.get("/api/get_coupons");
        console.log(response.data);
      } catch (error) {
        console.error("Error fetching coupons:", error);
      }
    }


  },
  created() {
    this.fetchCartData();
  },

  computed: {
    discountAmount() {
      return this.cartStore.discount;
    },
    totalPrice() {
      return this.cartStore.totalAmount || this.totalSum;
    },
    isGuest() {
      return !this.authStore.token;
    },
    guestCartItems() {
      return this.guestCartStore.cart;
    },
    guestTotalPrice() {
      return this.guestCartStore.cartTotal;
    }

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