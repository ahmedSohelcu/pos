<template>
  <aside class="app-sidebar">
    <!-- Sidebar Brand -->
    <div class="sidebar-brand">
      <a href="#" class="brand-link">
        <img
          src="admin/v1/assets/img/AdminLTELogo.png"
          alt="Logo"
          class="brand-image"
        />
        <span class="brand-text">GroceryPharma Admin</span>
      </a>
    </div>

    <!-- Sidebar Wrapper -->
    <div class="sidebar-wrapper">
      <nav>
        <ul class="sidebar-menu">
          <li v-for="menu in menus" :key="menu?.key" class="menu-item">
            <!-- Standalone link (no submenu) -->
            <router-link
              v-if="!menu?.items?.length"
              :to="{ name: menu.name }"
              class="menu-link standalone"
              active-class="active"
            >
              <div class="menu-left">
                <i :class="menu.icon"></i>
                <span>{{ menu.label }}</span>
              </div>
            </router-link>

            <!-- Parent Menu -->
            <template v-else>
            <div
              class="menu-link"
              :class="{ active: isMenuActive(menu) }"
              @click="toggleSidebar(menu.key)"
            >
              <div class="menu-left">
                <i :class="menu.icon"></i>
                <span>{{ menu.label }}</span>
              </div>

              <i
                class="bi"
                :class="
                  openMenu === menu.key ? 'bi-chevron-down' : 'bi-chevron-right'
                "
              ></i>
            </div>

            <!-- Submenu -->
            <transition name="slide">
              <ul
                v-if="menu.items && menu.items.length"
                v-show="openMenu === menu.key"
                class="submenu"
              >
                <li v-for="item in menu.items" :key="item.name">
                  <router-link
                    :to="{ name: item.name }"
                    class="submenu-link"
                    active-class="active-child"
                  >
                    <i class="bi bi-dot"></i>
                    {{ item.label }}
                  </router-link>
                </li>
              </ul>
            </transition>
            </template>
          </li>
        </ul>
      </nav>
    </div>
  </aside>
</template>

<script setup>
import { ref, watch, computed, onMounted } from 'vue';
import { useRoute } from 'vue-router';
import { AdminMenus } from '../../data/sidebar-menus';
import { filterMenus } from '../../ahmed-vue-kit/utils/menuFilter';
import { useAuthStore } from '../../ahmed-vue-kit/stores/authStore';

const route = useRoute();
const openMenu = ref(null);
const auth = useAuthStore();

// Initialize OverlayScrollbars on the sidebar wrapper
onMounted(() => {
  const wrapper = document.querySelector('.sidebar-wrapper');
  if (wrapper && window.OverlayScrollbarsGlobal?.OverlayScrollbars) {
    window.OverlayScrollbarsGlobal.OverlayScrollbars(wrapper, {
      scrollbars: {
        theme: 'os-theme-sidebar',
        autoHide: 'scroll',
        clickScroll: true,
      },
    });
  }
});

// Compute menus with proper filtering
const menus = computed(() => {
  if (!auth.initialized) return [];
  return filterMenus(AdminMenus);
});
/*
|--------------------------------------------------------------------------
| Helpers
|--------------------------------------------------------------------------
*/

// Check if menu is active based on route
const isMenuActive = (menu) => {
  if (!menu?.items) return false;

  return menu.items.some((item) => item.name === route.name);
};

// Toggle sidebar open/close
const toggleSidebar = (key) => {
  openMenu.value = openMenu.value === key ? null : key;
};

watch(
  () => route.name,
  () => {
    const activeMenu = menus.value.find((menu) =>
      menu?.items?.some((item) => item.name === route.name)
    );

    openMenu.value = activeMenu ? activeMenu.key : null;
  },
  { immediate: true }
);
</script>

<style scoped>
/* ===========================
Sidebar Base
=========================== */

.app-sidebar {
  width: 260px;
  height: 100vh;
  background: var(--sidebar-bg);
  color: var(--sidebar-text);
  display: flex;
  flex-direction: column;
  padding: 16px 12px;
  font-family: 'Source Sans 3', sans-serif;
  box-shadow: 3px 0 8px rgba(0, 0, 0, 0.3);
  border-right: 1px solid var(--sidebar-border);
  transition: background 0.3s ease, color 0.3s ease;
}

/* ===========================
Sidebar Brand
=========================== */

.sidebar-brand {
  display: flex;
  align-items: center;
  gap: 12px;
  padding: 12px 8px 20px 8px;
  border-bottom: 1px solid rgba(255, 255, 255, 0.1);
}

.brand-link {
  display: flex;
  align-items: center;
  gap: 10px;
  text-decoration: none;
}

.brand-image {
  width: 40px;
  height: 40px;
  border-radius: 10px;
  background: #4f46e5;
  padding: 4px;
}

.brand-text {
  font-size: 16px;
  font-weight: 700;
  color: var(--sidebar-brand-text);
}

/* ===========================
Sidebar Wrapper
=========================== */

.sidebar-wrapper {
  flex: 1 1 auto;
  min-height: 0;
  overflow-y: auto;
  scrollbar-width: thin;
  scrollbar-color: #000 transparent;
}

.sidebar-wrapper::-webkit-scrollbar {
  width: 6px;
}

.sidebar-wrapper::-webkit-scrollbar-thumb {
  background: #000;
  border-radius: 3px;
}

/* ===========================
Menu
=========================== */

.sidebar-menu {
  list-style: none;
  padding: 0;
  margin: 20px 0 0 0;
}

.menu-item {
  margin-top: 2px;
}

.menu-link {
  display: flex;
  justify-content: space-between;
  align-items: center;
  padding: 12px 16px;
  border-radius: 12px;
  color: var(--sidebar-text);
  cursor: pointer;
  transition: all 0.3s ease;
  position: relative;
  text-decoration: none;
}

.menu-link .menu-left {
  display: flex;
  align-items: center;
  gap: 12px;
}

.menu-link i {
  font-size: 16px;
  width: 20px;
}

.menu-link:hover {
  background: linear-gradient(135deg, #4f46e5, #2c2439);
  color: #fff;
  box-shadow: 0 4px 12px rgba(0, 0, 0, 0.25);
}

.menu-link.active {
  background: linear-gradient(135deg, #4f46e5, #2c2439);
  color: #fff;
}

.menu-link::before {
  content: '';
  position: absolute;
  left: 0;
  top: 0;
  width: 4px;
  height: 100%;
  background: transparent;
  border-radius: 4px 0 0 4px;
  transition: all 0.3s ease;
}

.menu-link.active::before,
.menu-link:hover::before {
  background: #fff;
}

/* ===========================
Submenu
=========================== */

.submenu {
  padding-left: 12px;
  margin-top: 6px;
}

.submenu-link {
  display: flex;
  align-items: center;
  gap: 6px;
  padding: 8px 12px;
  border-radius: 8px;
  color: var(--sidebar-submenu-text);
  font-size: 14px;
  text-decoration: none;
  transition: all 0.3s ease;
}

.submenu-link i {
  font-size: 10px;
}

.submenu-link:hover {
  background: var(--sidebar-submenu-hover-bg);
  color: var(--sidebar-brand-text);
}

.active-child {
  background: var(--sidebar-submenu-active-bg);
  color: var(--sidebar-submenu-active-color) !important;
}

/* ===========================
Animation
=========================== */

.slide-enter-active,
.slide-leave-active {
  transition: all 0.25s ease;
}

.slide-enter-from,
.slide-leave-to {
  opacity: 0;
  transform: translateY(-5px);
}
</style>
