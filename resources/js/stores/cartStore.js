import { defineStore } from 'pinia';

export const useCartStore = defineStore('cart', {
  state: () => ({
    couponCode: null,
    discount: 0,
    totalAmount: 0,
  }),
  actions: {
    setCoupon(code, discount, total) {
      this.couponCode = code;
      this.discount = discount;
      this.totalAmount = total;
    },
    clearCoupon() {
      this.couponCode = null;
      this.discount = 0;
      this.totalAmount = 0;
    }
  }
});
