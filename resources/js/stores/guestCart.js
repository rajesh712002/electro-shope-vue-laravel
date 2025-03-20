import { defineStore } from "pinia";
import CryptoJS from "crypto-js";

const SECRET_KEY = "AbCbA"; 

export const useGuestCartStore = defineStore("guestCart", {
    state: () => ({
        cart: getDecryptedCart(),
    }),

    getters: {
        totalItems(state) {
            return state.cart.reduce((sum, item) => sum + item.qty, 0);
        },
        cartTotal(state) {
            return state.cart.reduce((total, item) => total + item.price * item.qty, 0);
        }
    },

    actions: {
        addToCart(product) {
            const existingItem = this.cart.find(item => item.prod_id === product.id);
            if (existingItem) {
                existingItem.qty += 1; 
            } else {
                this.cart.push({
                    prod_id: product.id,
                    qty: 1,
                    price: product.price,
                    name: product.prod_name,
                    image: product.image || (product.product_images?.length > 0 ? product.product_images[0].images : ''),
                    max_qty: product.qty
                });
            }
            saveEncryptedCart(this.cart);
        },

        removeFromCart(productId) {
            this.cart = this.cart.filter(item => item.prod_id !== productId);
            saveEncryptedCart(this.cart);
        },

        updateCartItem(productId, action) {
            const item = this.cart.find(i => i.prod_id === productId);
            if (item) {
                if (action === "increase") {
                    item.qty += 1;
                } else if (action === "decrease" && item.qty > 1) {
                    item.qty -= 1;
                } else {
                    this.removeFromCart(productId);
                    return;
                }
                saveEncryptedCart(this.cart);
            }
        },

        clearCart() {
            this.cart = [];
            localStorage.removeItem("guestCart");
        }
    }
});




function encryptCart(cart) {
    return CryptoJS.AES.encrypt(JSON.stringify(cart), SECRET_KEY).toString();
}

function decryptCart(encryptedData) {
    try {
        const bytes = CryptoJS.AES.decrypt(encryptedData, SECRET_KEY);
        return JSON.parse(bytes.toString(CryptoJS.enc.Utf8));
    } catch (error) {
        return [];
    }
}

function saveEncryptedCart(cart) {
    const encryptedCart = encryptCart(cart);
    localStorage.setItem("guestCart", encryptedCart);
}

function getDecryptedCart() {
    const encryptedCart = localStorage.getItem("guestCart");
    return encryptedCart ? decryptCart(encryptedCart) : [];
}

