import { defineStore } from "pinia";
import axios from "axios";

export const useAdminAuthStore = defineStore("adminAuth", {
    state: () => ({
        admin: null,  
        token:localStorage.getItem("adminAuthToken") || null,
    }),

    getters: {
        isAuthenticated(state) {
            return !!state.token;
        },
        adminId(state) {
            return state.admin ? state.admin.id : null;
        },
        adminName(state) {
            return state.admin ? state.admin.name : "Admin";
        },
    },

    actions: {
        // Initialize authentication after login
        initAuth(admin, token) {
            this.admin = admin;
            this.token = token;
            
            // Store token in local storage
            localStorage.setItem("adminAuthToken", token);
            axios.defaults.headers.common["Authorization"] = `Bearer ${token}`;
        },
  
        // Restore authentication from local storage
        async restoreAuth() {
            const storedToken = localStorage.getItem("adminAuthToken");
            if (storedToken) {
                this.token = storedToken;
                axios.defaults.headers.common["Authorization"] = `Bearer ${storedToken}`;
                await this.fetchAdmin();
            }
        },

        // Fetch admin details
        async fetchAdmin() {
            if (!this.token) return;
            try {
                const response = await axios.get("/api/admin/me");
                this.admin = response.data;
            } catch (error) {
                console.error("Failed to fetch admin", error);
                this.logoutAdmin();
            }
        },

        // Logout admin
        logoutAdmin() {
            this.admin = null;
            this.token = null;
            localStorage.removeItem("adminAuthToken");
            delete axios.defaults.headers.common["Authorization"];
        },
    },
});
