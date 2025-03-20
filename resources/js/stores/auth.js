import { defineStore } from "pinia";
import axios from "axios";

export const useAuthStore = defineStore("auth", {
    state: () => ({
        user: null,  
        token: localStorage.getItem("authToken") || null,
    }),
    getters: {
        isAuthenticated(state) {
            return !!state.token;
        },
        userId(state) {
            return state.user ? state.user.id : null;
        },
        userName(state) {
            return state.user ? state.user.name : "Guest";
        },
    },
    actions: {
        async login(userData, token) {
            this.token = token;
            localStorage.setItem("authToken", token);
            axios.defaults.headers.common["Authorization"] = `Bearer ${token}`;

            
            await this.fetchUser();
        },

        async fetchUser() {
            if (!this.token) return;

            try {
                const response = await axios.get("/api/user"); 
                this.user = response.data; 
                console.log('hii',response)
            } catch (error) {
                console.error("Failed to fetch user", error);
                this.logout();
            }
        },

        logout() {
            this.user = null;
            this.token = null;
            localStorage.removeItem("authToken");
            delete axios.defaults.headers.common["Authorization"];
            // this.$router.push("/user-login");
        },
    },
});
