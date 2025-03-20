<template>
    <nav class="main-header navbar navbar-expand navbar-white navbar-light">
        <ul class="navbar-nav ml-auto">
            <!-- Fullscreen Toggle -->
            <li class="nav-item">
                <a href="#" @click="toggleFullscreen" class="nav-link">
                    <i class="fas fa-expand-arrows-alt"></i>
                </a>
            </li>

            <!-- Dropdown for Admin Profile -->
            <li class="nav-item dropdown" ref="dropdownMenu">
                <a @click.prevent="toggleDropdown" class="nav-link p-0 pr-3">
                    <img :src="getAdminAvatar()" class="img-circle elevation-2" width="40" height="40" alt="Admin Avatar" />
                </a>
                <div ref="dropdownContent" 
                     class="dropdown-menu dropdown-menu-lg dropdown-menu-right p-3" 
                     :class="{ 'show': isDropdownOpen }" 
                     v-show="isDropdownOpen"
                     @click.stop>
                    <h4 class="h4 mb-0"><strong>{{ adminUser.name }}</strong></h4>
                    <div class="mb-3">{{ adminUser.email }}</div>
                    <div class="dropdown-divider"></div>
                    <a href="#" class="dropdown-item">
                        <i class="fas fa-user-cog mr-2"></i> Settings
                    </a>
                    <div class="dropdown-divider"></div>
                    <router-link to="/admin/change-password" class="dropdown-item">
                        <i class="fas fa-lock mr-2"></i> Change Password
                    </router-link>
                    <div class="dropdown-divider"></div>
                    <a @click="logout" class="dropdown-item text-danger">
                        <i class="fas fa-sign-out-alt mr-2"></i> Logout
                    </a>
                </div>
            </li>
        </ul>
    </nav>
</template>

<script>
import { ref, onMounted, onUnmounted } from "vue";
import axios from "axios";

export default {
    setup() {
        const adminUser = ref({ name: "Admin", email: "admin@example.com" });
        const isDropdownOpen = ref(false);
        const dropdownMenu = ref(null);
        const dropdownContent = ref(null);

        const toggleFullscreen = () => {
            if (!document.fullscreenElement) {
                document.documentElement.requestFullscreen();
            } else if (document.exitFullscreen) {
                document.exitFullscreen();
            }
        };

        const toggleDropdown = (event) => {
            console.log("Dropdown toggle clicked");
            isDropdownOpen.value = !isDropdownOpen.value;
            console.log("Dropdown open state:", isDropdownOpen.value);
            event.stopPropagation();
        };

        const closeDropdown = (event) => {
            if (dropdownContent.value && !dropdownContent.value.contains(event.target) && 
                dropdownMenu.value && !dropdownMenu.value.contains(event.target)) {
                console.log("Closing dropdown");
                isDropdownOpen.value = false;
            }
        };

        const logout = async () => {
            try {
                await axios.get("/api/admin/logout");
                window.location.href = "/admin/login";
            } catch (error) {
                console.error("Logout failed:", error);
            }
        };

        const getAdminAvatar = () => {
            return "/admin_assets/img/avatar5.png";
        };

        onMounted(() => {
            document.addEventListener("click", closeDropdown);
        });

        onUnmounted(() => {
            document.removeEventListener("click", closeDropdown);
        });

        return {
            adminUser,
            isDropdownOpen,
            toggleFullscreen,
            toggleDropdown,
            logout,
            getAdminAvatar,
            dropdownMenu,
            dropdownContent,
        };
    },
};
</script>

<style scoped>
.img-circle {
    width: 40px !important;
    height: 40px !important;
}


.dropdown-menu {
    display: none;
    position: absolute;
    right: 0;
    top: 50px;
    z-index: 1000;
    background: white;
    box-shadow: 0px 4px 6px rgba(0, 0, 0, 0.1);
    min-width: 200px;
    border-radius: 5px;
    padding: 10px;
}

.dropdown-menu.show {
    display: block;
}
</style>
