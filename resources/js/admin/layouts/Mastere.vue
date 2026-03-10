<template>
  <div>
    <!-- Check layout type -->
    <div v-if="$route.meta.layout === 'master'" class="app-wrapper">
      <Nav />

      <Sidebar />

      <main class="app-main">
        <Breadcumbs />
        <div class="app-content page-wrapper">
          <router-view v-slot="{ Component, route }">
            <transition name="page">
              <component :is="Component" :key="route.fullPath" />
            </transition>
          </router-view>
        </div>
      </main>

      <Footer />
    </div>

    <!-- Blank layout (login page) -->
    <div v-else>
      <router-view />
    </div>
  </div>
</template>

<script setup>
import Nav from '../components/Nav.vue';
import Sidebar from '../components/Sidebar.vue';
import Footer from '../components/Footer.vue';
import Breadcumbs from '../components/Breadcumbs.vue';
import { useAuthStore } from '../../ahmed-vue-kit/stores/authStore';
const auth = useAuthStore();
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
