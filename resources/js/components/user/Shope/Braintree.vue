<template>
  <div>
    <!-- Loading Overlay -->
    <div v-if="loading" class="overlay">
      <div class="spinner-container">
        <div class="spinner-border" role="status">
          <span class="visually-hidden">Processing...</span>
        </div>
      </div>
    </div>

    <!-- Payment Form -->
    <div class="payment-container">
      <h2>Braintree Payment</h2>
      <form @submit.prevent="submitPayment">
        <label for="amount">Amount</label>
        <input type="text" id="amount" v-model="amount" readonly />

        <label for="dropin-container">Payment Details</label>
        <div id="dropin-container"></div>

        <button type="submit" :disabled="!dropinInstance">Pay</button>
      </form>
    </div>
  </div>
</template>

<script>
import dropin from 'braintree-web-drop-in';
import axios from 'axios';
import { useCartStore } from "../../../stores/cartStore";

export default {
  data() {
    return {
      cartStore: useCartStore(),
      amount: '',
      loading: false,
      clientToken: '',
      dropinInstance: null,
      orderData: {   },
      discountAmount: 0,
      couponCode: '',
      newTotal: 0
    };
  },
  async mounted() {

    await this.getClientToken();
  },
  methods: {
    async getClientToken() {
      try {
       const responsee= await axios.get('/api/get-checkout-data', {
          withCredentials: true,
          headers: { 'Accept': 'application/json' }
        });
        this.orderData = responsee.data.checkoutData;
        console.log(this.orderData)
        console.log('get', responsee)
        const response = await axios.get('/api/braintree');
        this.clientToken = response.data.token;
        this.amount = this.cartStore.totalAmount;
        console.log(response)
        console.log('Client Token:', this.clientToken);
        if (this.clientToken) {
          this.initializeBraintree();
        }
      } catch (error) {
        console.error('Error fetching client token:', error);
      }
    },
    initializeBraintree() {
      if (!this.clientToken) {
        console.error('Braintree Initialization Error: Client token is missing.');
        return;
      }

      dropin.create(
        {
          authorization: this.clientToken,
          container: '#dropin-container',
          card: { cardholderName: true },
        },
        (error, instance) => {
          if (error) {
            console.error('Braintree Initialization Error:', error);
            return;
          }
          this.dropinInstance = instance;
        }
      );
    },
    async submitPayment() {
      if (!this.dropinInstance) return;
      this.loading = true;
      this.dropinInstance.requestPaymentMethod(async (error, payload) => {
        if (error) {
          console.error('Payment method request error:', error);
          this.loading = false;
          return;
        }

        try {
      const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

      const response = await axios.post('/api/braintree/store', {
        amount: this.amount,
        payment_method_nonce: payload.nonce,
        order_data: this.orderData, 
        discount_amount: this.discountAmount, 
        coupon_code: this.couponCode,
        new_total: this.newTotal
      }, {
        headers: {
          'X-CSRF-TOKEN': csrfToken
        }
      });

      console.log('Payment Success:', response.data);
    } catch (error) {
      console.error('Payment error:', error);
    } finally {
      this.loading = false;
    }
      });
    },
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

.spinner-border {
  width: 5rem;
  height: 5rem;
  color: #fff;
}

.payment-container {
  width: 400px;
  margin: 50px auto;
  padding: 20px;
  background-color: #fff;
  box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
  border-radius: 8px;
  text-align: center;
}

button {
  width: 100%;
  padding: 10px;
  background-color: #007bff;
  color: white;
  border: none;
  border-radius: 5px;
  font-size: 16px;
  cursor: pointer;
}

button:disabled {
  background-color: gray;
  cursor: not-allowed;
}

button:hover {
  background-color: #0056b3;
}
</style>
