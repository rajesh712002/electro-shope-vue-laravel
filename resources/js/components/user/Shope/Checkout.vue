<template>
  <Header />
  <main>
    <section class="section-5 pt-3 pb-3 mb-3 bg-white">
      <div class="container">
        <div class="light-font">
          <ol class="breadcrumb primary-color mb-0">
            <li class="breadcrumb-item"><router-link class="white-text" to="/">Home</router-link></li>
            <li class="breadcrumb-item"><router-link class="white-text" to="/shop">Shop</router-link></li>
            <li class="breadcrumb-item">Checkout</li>
          </ol>
        </div>
      </div>
    </section>

    <section class="section-9 pt-4">
      <div class="overlay" v-if="loading">
        <div class="spinner-container">
          <div class="spinner-border" role="status">
            <span class="visually-hidden">Loading...</span>
          </div>
        </div>
      </div>

      <div class="container">
        <div v-if="status" class="alert alert-danger">{{ status }}</div>

        <form @submit.prevent="submitCheckout">
          <div class="row">
            <div class="col-md-8">
              <div class="sub-title">
                <h2>Shipping Address</h2>
              </div>
              <div class="card shadow-lg border-0">
                <div class="card-body checkout-form">
                  <div class="row">
                    <div class="col-md-12" v-for="(field, index) in formFields" :key="index">
                      <div class="mb-3">
                        <input :type="field.type" v-model="checkoutForm[field.model]" class="form-control"
                          :placeholder="field.placeholder" />
                        <h6 class="error" v-if="errors[field.model]">{{ errors[field.model] }}</h6>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <div class="col-md-4">
              <div class="sub-title">
                <h2>Order Summary</h2>
              </div>
              <div class="card cart-summary">
                <div class="card-body">
                  <div v-for="product in products" :key="product.id" class="d-flex justify-content-between pb-2">
                    <div class="h6">{{ product.prod_name }} X <b><u><i>{{ product.cqty }}</i></u></b></div>
                    <div class="h6"><i class="fa fa-inr" aria-hidden="true">{{ product.price * product.cqty }}</i></div>
                  </div>
                  <div class="d-flex justify-content-between summery-end">
                    <div class="h6"><strong>Subtotal</strong></div>
                    <div class="h6"><strong><i class="fa fa-inr" aria-hidden="true">{{ totalSum }}</i></strong></div>
                  </div>
                  <div class="d-flex justify-content-between mt-2">
                    <div class="h6"><strong>Discount</strong></div>
                    <strong><i class="fa fa-inr" aria-hidden="true">{{ discount }}</i></strong>
                  </div>
                  <div class="d-flex justify-content-between mt-2">
                    <div class="h6"><strong>Shipping</strong></div>
                    <div class="h6"><strong>Free</strong></div>
                  </div>
                  <div class="d-flex justify-content-between mt-2 summery-end">
                    <div class="h5"><strong>Total</strong></div>
                    <div class="h5"><strong><i class="fa fa-inr" aria-hidden="true">{{ newTotal }}</i></strong></div>
                  </div>
                </div>
              </div>
              <div class="card payment-form">
                <h3 class="card-title h5 mb-3">Payment Details</h3>
                <div>
                  <input type="radio" v-model="checkoutForm.payment_method" value="cod" /> COD
                  <button type="submit" class="btn-dark btn btn-block w-100">{{ newTotal }} Pay On COD</button>
                </div>
                <!-- <div>
                  <input type="radio" v-model="checkoutForm.payment_method" value="stripe" /> Pay With Stripe
                  <button type="submit" class="btn-dark btn btn-block w-100">{{ newTotal }} Pay Now</button>
                </div> -->
                <div>
                  <input type="radio" v-model="checkoutForm.payment_method" value="braintree" /> Pay With braintree
                  <button type="submit" class="btn-dark btn btn-block w-100">{{ newTotal }} Pay Now</button>
                </div>
              </div>
            </div>
          </div>
        </form>
      </div>
    </section>
  </main>
</template>

<script>
import Header from "../include/Header.vue";

export default {
  components: {
    Header
  },
  data() {
    return {
      loading: false,
      status: '',
      checkoutForm: {
        first_name: '',
        last_name: '',
        email: '',
        country: 'India',
        address: '',
        apartment: '',
        city: '',
        state: '',
        pincode: '',
        mobile: '',
        order_notes: '',
        payment_method: 'cod',
      },
      formFields: [
        { model: 'first_name', type: 'text', placeholder: 'First Name' },
        { model: 'last_name', type: 'text', placeholder: 'Last Name' },
        { model: 'email', type: 'text', placeholder: 'Email' },
        { model: 'address', type: 'text', placeholder: 'Address' },
        { model: 'apartment', type: 'text', placeholder: 'Apartment, suite, unit, etc. (optional)' },
        { model: 'city', type: 'text', placeholder: 'City' },
        { model: 'state', type: 'text', placeholder: 'State' },
        { model: 'pincode', type: 'text', placeholder: 'Pincode' },
        { model: 'mobile', type: 'text', placeholder: 'Mobile No.' },
        { model: 'order_notes', type: 'text', placeholder: 'Order Notes (optional)' },
      ],
      errors: {},
      products: [],
      totalSum: 0,
      discount: 0,
      newTotal: 0,
    };
  },
  methods: {
    async submitCheckout() {
      this.loading = true;
      try {
        const formData = new FormData();
        formData.append("first_name", this.checkoutForm.first_name);
        formData.append("last_name", this.checkoutForm.last_name);
        formData.append("email", this.checkoutForm.email);
        formData.append("country", this.checkoutForm.country);
        formData.append("address", this.checkoutForm.address);
        formData.append("apartment", this.checkoutForm.apartment);
        formData.append("city", this.checkoutForm.city);
        formData.append("state", this.checkoutForm.state);
        formData.append("zip", this.checkoutForm.pincode);
        formData.append("mobile", this.checkoutForm.mobile);
        formData.append("order_notes", this.checkoutForm.order_notes);
        formData.append("payment_method", this.checkoutForm.payment_method);

        console.log('HII', formData)
        if (this.checkoutForm.payment_method === "braintree") {
          // Store checkout data in Vuex or LocalStorage if needed
          // localStorage.setItem("checkoutData", JSON.stringify(this.checkoutForm));

          // // Redirect to the Braintree payment page (Vue Component)
          // this.$router.push({ name: "braintree-payment" });
          //  await axios.post('/api/store-checkout-data', formData)
          //     .then(response => {
          //       console.log("Checkout data stored in session");

          //       // Redirect to Braintree component
          //       this.$router.push({ name: "braintree-payment" });
          //     })
          //     .catch(error => console.error(error));

          await axios.post('/api/store-checkout-data', formData, {
            withCredentials: true,
            headers: {
              'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
              'Accept': 'application/json'
            }
          });
                this.$router.push({ name: "braintree-payment" });


        } else {
          // Handle other payment methods (COD)
          const response = await axios.post("/api/checkout", formData);
          console.log(response);
          this.status = "Order placed successfully!";
        }
      } catch (error) {
        console.error("Error:", error);
        this.status = "An error occurred during checkout.";
      } finally {
        this.loading = false;
      }
    },

    async fetchCheckout() {
      try {
        const response = await axios.get("/api/checkout");
        console.log(response)
        this.checkoutForm = response.data.customerAddress
        this.products = response.data.products
        this.totalSum = response.data.totalSum
        this.discount = response.data.discount
        this.newTotal = response.data.newTotal
      } catch (error) {
        console.error("Error fetching profile:", error);
      }
    },
  },

  mounted() {
    this.fetchCheckout();
  },
};
</script>

<style>
.overlay {
  position: fixed;
  top: 0;
  left: 0;
  width: 100%;
  height: 100%;
  background-color: rgba(0, 0, 0, 0.5);
  display: flex;
  justify-content: center;
  align-items: center;
  z-index: 9999;
}
</style>



<!-- <template>
     <div class="container">
        <div class="col-6 offset-3">
            <div class="card bg-light">
                <div class="card-header">Payment Information</div>
                <div class="card-body">
                    <div class="alert alert-success" v-if="nonce">
                        Successfully generated nonce.
                    </div>
                    <div class="alert alert-danger" v-if="error">
                        {{ error }}
                    </div>
                    <form>
                        <div class="form-group">
                            <label for="amount">Amount</label>
                            <div class="input-group">
                                <div class="input-group-prepend"><span class="input-group-text">$</span></div>
                                <input type="number" id="amount" v-model="amount" class="form-control" placeholder="Enter Amount">
                            </div>
                        </div>
                         <hr />
                        <div class="form-group">
                            <label>Credit Card Number</label>
                            <div id="creditCardNumber" class="form-control"></div>
                        </div>
                        <div class="form-group">
                            <div class="row">
                                <div class="col-6">
                                    <label>Expire Date</label>
                                    <div id="expireDate" class="form-control"></div>
                                </div>
                                <div class="col-6">
                                    <label>CVV</label>
                                    <div id="cvv" class="form-control"></div>
                                </div>
                            </div>
                        </div>
                        <button class="btn btn-primary btn-block" @click.prevent="payWithCreditCard">Pay with Credit Card</button>
                        <hr />
                        <div id="paypalButton"></div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import braintree from 'braintree-web';
import paypal from 'paypal-checkout';

export default {
    data() {
        return {
            hostedFieldInstance: false,
            nonce: "",
            error: "",
            amount: 10
        }
    },
    methods: {
        payWithCreditCard() {
            if(this.hostedFieldInstance)
            {
                this.error = "";
                this.nonce = "";

                this.hostedFieldInstance.tokenize().then(payload => {
                    console.log(payload);
                    this.nonce = payload.nonce;
                })
                .catch(err => {
                    console.error(err);
                    this.error = err.message;
                })
            }
        }
    },
    mounted() {
        braintree.client.create({
            authorization: "sandbox_93smtrz3_bbgx4xf7h8bx24xg"
        })
        .then(clientInstance => {
            let options = {
                client: clientInstance,
                styles: {
                    input: {
                        'font-size': '14px',
                        'font-family': 'Open Sans'
                    }
                },
                fields: {
                    number: {
                        selector: '#creditCardNumber',
                        placeholder: 'Enter Credit Card'
                    },
                    cvv: {
                        selector: '#cvv',
                        placeholder: 'Enter CVV'
                    },
                    expirationDate: {
                        selector: '#expireDate',
                        placeholder: '00 / 0000'
                    }
                }
            }

            return Promise.all([
                braintree.hostedFields.create(options),
                braintree.paypalCheckout.create({ client: clientInstance })
            ])

        })
        .then(instances => {

            const hostedFieldInstance    = instances[0];
            const paypalCheckoutInstance = instances[1];

            // Use hostedFieldInstance to send data to Braintree
            this.hostedFieldInstance = hostedFieldInstance;

            // Setup PayPal Button

                return paypal.Button.render({
                    env: 'sandbox',
                    style: {
                        label: 'paypal',
                        size: 'responsive',
                        shape: 'rect'
                    },
                    payment: () => {
                        return paypalCheckoutInstance.createPayment({
                                flow: 'checkout',
                                intent: 'sale',
                                amount: parseFloat(this.amount) > 0 ? this.amount : 10,
                                displayName: 'Braintree Testing',
                                currency: 'USD'
                        })
                    },
                    onAuthorize: (data, options) => {
                        return paypalCheckoutInstance.tokenizePayment(data).then(payload => {
                            console.log(payload);
                            this.error = "";
                            this.nonce = payload.nonce;
                        })
                    },
                    onCancel: (data) => {
                        console.log(data);
                        console.log("Payment Cancelled");
                    },
                    onError: (err) => {
                        console.error(err);
                        this.error = "An error occurred while processing the paypal payment.";
                    }
                }, '#paypalButton')
        })
        .catch(err => {

        });
    }
}
</script>

<style>
    body {
        padding: 20px;
    }
</style> -->