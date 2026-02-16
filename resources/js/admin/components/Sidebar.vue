<template>
  <aside class="app-sidebar bg-body-secondary shadow" data-bs-theme="dark">
    
    <!-- Sidebar Brand -->
    <div class="sidebar-brand">
      <a href="#" class="brand-link">
        <img
          src="admin/v1/assets/img/AdminLTELogo.png"
          alt="AdminLTE Logo"
          class="brand-image opacity-75 shadow"
        />
        <span class="brand-text fw-light">AdminLTE 4</span>
      </a>
    </div>

    <!-- Sidebar Wrapper -->
    <div class="sidebar-wrapper">
      <nav class="mt-2">
        <ul class="nav sidebar-menu flex-column" role="menu">
          
          <li
            v-for="menu in menus"
            :key="menu.key"
            class="nav-item has-treeview"
            :class="{ 'menu-open': openMenu === menu.key }"
          >
            
            <!-- Parent Menu -->
            <a
              href="#"
              class="nav-link"
              :class="{ 'bg-primary': isMenuActive(menu) }"
              @click.prevent="toggleSidebar(menu.key)"
            >
              <i :class="['nav-icon', menu.icon]"></i>
              <p>
                {{ menu.label }}
                <i
                  class="nav-arrow bi"
                  :class="openMenu === menu.key
                    ? 'bi-chevron-down'
                    : 'bi-chevron-right'"
                ></i>
              </p>
            </a>

            <!-- Child Menu -->
            <ul class="nav nav-treeview">
              <li
                v-for="item in menu.items"
                :key="item.name"
                class="nav-item"
              >
                <router-link
                  :to="{ name: item.name }"
                  class="nav-link"
                  active-class="active"
                >
                  <p>{{ item.label }}</p>
                </router-link>
              </li>
            </ul>

          </li>

        </ul>
      </nav>
    </div>
  </aside>
</template>

<script setup>
    import { ref, watch } from 'vue'
    import { useRoute } from 'vue-router'

    const route = useRoute()
    const openMenu = ref(null)


    // ------------------
    // Menu Configuration
    // ------------------
    const menus = ref([
        {
            key: 'dashboard',
            label: 'Dashboard',
            icon: 'fas fa-th',
            items: [
            { name: 'component', label: 'Component' },
            { name: 'dashboard', label: 'Dashboard' },
            { name: 'dashboard-2', label: 'Dashboard 2' },
            { name: 'dashboard-3', label: 'Dashboard 3' }
            ]
        },
        {
            key: 'tables',
            label: 'Tables',
            icon: 'bi bi-table',
            items: [
            { name: 'table-component', label: 'Table Component Example' },
            { name: 'sample-tables', label: 'Sample Tables' }
            ]
        },
        {
            key: 'widgets',
            label: 'Widgets',
            icon: 'bi bi-box-seam-fill',
            items: [
            { name: 'small-box', label: 'Small Box' },
            { name: 'info-box', label: 'Info Box' },
            { name: 'cards', label: 'Cards' }
            ]
        },
        {
            key: 'forms',
            label: 'Forms',
            icon: 'bi bi-pencil-square',
            items: [
            { name: 'form', label: 'General Elements' }
            ]
        },
        {
            key: 'ui',
            label: 'UI Elements',
            icon: 'bi bi-tree-fill',
            items: [
                { name: 'general-ui', label: 'General' },
                { name: 'icon', label: 'Icon' },
                { name: 'timeline', label: 'Timeline' }
            ]
        }
    ])


    // ------------------
    // Helpers
    // ------------------

    const isMenuActive = (menu) => {
        return menu.items.some(item => item.name === route.name)
    }

    const toggleSidebar = (key) => {
        openMenu.value = openMenu.value === key ? null : key
    }

    watch(
    () => route.name,
    () => {
        const activeMenu = menus.value.find(menu =>
        menu.items.some(item => item.name === route.name)
        )

        openMenu.value = activeMenu ? activeMenu.key : null
    },
    { immediate: true }
    )

</script>

<style scoped>
    .router-link-exact-active{
        background-color: #fff!important;
        color: #000 !important;
    }
    .sidebar-wrapper {
        transition: all 0.3s ease;
    }

    .router-link-active,
    .nav-link.active {
        background-color: rgba(255, 255, 255, 0.9);
        color: #000 !important;
    }

    .nav-treeview {
        transition: all 0.3s ease;
    }
</style>
