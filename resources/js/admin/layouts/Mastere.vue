<template>
  <!--begin::App Wrapper-->
  <div class="app-wrapper">
    <!-- header Navbar -->
    <Nav />
    <!--end header Navbar -->

    <!--begin::Sidebar-->
    <Sidebar />
    <!--end::Sidebar-->

    <!--begin::App Main-->
    <main class="app-main">
      <!-- Breadcrumbs -->
      <Breadcumbs />

      <!--begin::App Content-->
      <div class="app-content page-wrapper">
        <!-- <div class="col-md-4">
          <select class="select2 form-control activate-select2" name="state">
            <option value="AL">Alabama</option>
            <option value="WY">Wyoming</option>
          </select>
        </div>
        <br> -->

        <!-- 🔥 ROUTE WITH TRANSITION -->
        <router-view v-slot="{ Component, route }">
          <!-- Fade-in only transition -->
          <transition name="page">
            <component :is="Component" :key="route.fullPath" />
          </transition>
        </router-view>

        <!-- 🔥 ROUTE WITHOUT TRANSITION -->
        <!-- <div class="app-content">             
            <router-view :key="$route.fullPath"/>           
          </div>  -->
      </div>
      <!--end::App Content-->
    </main>
    <!--end::App Main-->

    <!-- Footer component -->
    <Footer />
  </div>
  <!--end::App Wrapper-->
</template>

<script setup>
import Nav from '../components/Nav.vue';
import Sidebar from '../components/Sidebar.vue';
import Footer from '../components/Footer.vue';
import Breadcumbs from '../components/Breadcumbs.vue';
</script>

<style>
/* ===============================
   Professional Page Transition
=================================*/

/* Fade-in only animation */
.page-enter-active {
  transition:
    opacity 0.3s ease,
    transform 0.3s ease;
}

.page-enter-from {
  opacity: 0;
  transform: translateY(15px);
}

.page-enter-to {
  opacity: 1;
  transform: translateX(0);
}

/* Leave animation removed to prevent blank page */
</style>
