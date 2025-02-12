<template>
    <div class="wrapper">
        <!-- Navbar -->
        <NavBar />

        <!-- Sidebar -->
        <SideBar />

        <!-- Content Wrapper -->
        <div class="content-wrapper">
            <router-view />
        </div>

        <!-- Footer -->
        <FooterComponent />

        <!-- Overlay Loader -->
        <div v-if="loading" class="overlay">
            <div class="spinner-border" role="status">
                <span class="visually-hidden">Loading...</span>
            </div>
        </div>
    </div>
</template>

<script>
import NavBar from "../components/admin/Layouts/NavBar.vue";
import SideBar from "../components/admin/Layouts/SideBar.vue";
import '../../css/admin_assets/plugins/fontawesome-free/css/all.min.css';
import '../../css/admin_assets/css/adminlte.min.css';
import '../../css/admin_assets/css/custom.css';
import '../../css/admin_assets/css/datetimepicker.css';
// import FooterComponent from "@/components/admin/Layouts/FooterComponent.vue";

export default {
    components: {
        NavBar,
        SideBar,
        // FooterComponent,
    },
    data() {
        return {
            loading: false, // Control global loading state
        };
    },
};
</script>

<style scoped>
/* Overlay spinner */
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
