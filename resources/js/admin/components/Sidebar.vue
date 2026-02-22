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

          <li
            v-for="menu in menus"
            :key="menu.key"
            class="menu-item"
          >
            <!-- Parent Menu -->
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
                :class="openMenu === menu.key
                  ? 'bi-chevron-down'
                  : 'bi-chevron-right'"
              ></i>
            </div>

            <!-- Submenu -->
            <transition name="slide">
              <ul
                v-show="openMenu === menu.key"
                class="submenu"
              >
                <li
                  v-for="item in menu.items"
                  :key="item.name"
                >
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

          </li>

        </ul>
      </nav>
    </div>
  </aside>
</template>

<script setup>
import { ref, watch } from 'vue'
import { useRoute } from 'vue-router'
import { menus } from '../../data/sidebar-menus'

const route = useRoute()
const openMenu = ref(null)

// ------------------
// Helpers
// ------------------
const isMenuActive = (menu) => {
  return menu.items.some(item => item.name === route.name)
}

const toggleSidebar = (key) => {
  openMenu.value = openMenu.value === key ? null : key
}

// Auto open active menu
watch(
  () => route.name,
  () => {
    const activeMenu = menus.find(menu =>
      menu.items.some(item => item.name === route.name)
    )
    openMenu.value = activeMenu ? activeMenu.key : null
  },
  { immediate: true }
)
</script>

<style scoped>
/* ===========================
   Sidebar Base
=========================== */
.app-sidebar {
  width: 260px;
  height: 100vh;
  background: #111827;
  color: #d1d5db;
  display: flex;
  flex-direction: column;
  padding: 16px 12px;
  font-family: 'Source Sans 3', sans-serif;
  box-shadow: 3px 0 8px rgba(0,0,0,0.3);
  border-right: 1px solid #2c2f3a;
}

/* ===========================
   Sidebar Brand
=========================== */
.sidebar-brand {
  display: flex;
  align-items: center;
  gap: 12px;
  padding: 12px 8px 20px 8px;
  border-bottom: 1px solid rgba(255,255,255,0.1);
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
  color: #f9fafb;
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
  margin-top: 8px;
}

.menu-link {
  display: flex;
  justify-content: space-between;
  align-items: center;
  padding: 12px 16px;
  border-radius: 12px;
  color: #d1d5db;
  cursor: pointer;
  transition: all 0.3s ease;
  position: relative;
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

/* Hover and Active */
.menu-link:hover {
  background: linear-gradient(135deg, #6366f1, #8b5cf6);
  color: #fff;
  box-shadow: 0 4px 12px rgba(0,0,0,0.25);
}
.menu-link.active {
  background: linear-gradient(135deg, #4f46e5, #7c3aed);
  color: #fff;
}

/* Left indicator for active/hover */
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
  color: #9ca3af;
  font-size: 14px;
  text-decoration: none;
  transition: all 0.3s ease;
  position: relative;
}

.submenu-link i {
  font-size: 10px;
}

.submenu-link:hover {
  background: rgba(99, 102, 241, 0.2);
  color: #fff;
}

.active-child {
  background: rgba(99, 102, 241, 0.25);
  color: #fff !important;
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