<template>
  <aside class="app-sidebar bg-body-secondary shadow" data-bs-theme="dark">
    <!-- Sidebar Brand -->
    <div class="sidebar-brand">
      <a href="./index.html" class="brand-link">
        <img src="admin/v1/assets/img/AdminLTELogo.png" alt="AdminLTE Logo" class="brand-image opacity-75 shadow" />
        <!-- <span class="brand-text fw-light">AdminLTE 4</span>         -->
      </a>
        
        <span class="badge badge-info">{{ counter || 'counter' }} </span>
        <span @click="increment" class="badge badge-info">counter</span>
    </div>

    <!-- Sidebar Wrapper -->
    <div class="sidebar-wrapper">
      <nav class="mt-2">
        <ul class="nav sidebar-menu flex-column" data-lte-toggle="treeview" role="menu" data-accordion="false">        
          
          <!-- Generate Menu Items Dynamically -->
          <li
            v-for="menu in menus"
            :key="menu.key"
            class="nav-item has-treeview"
            :class="{ 'menu-open': openMenu === menu.key || isActiveMenuItem(menu.items.map(i => i.name)) }"
          >
            <a
              @click.prevent="toggleSidebar(menu.key)"
              href="#"
              class="nav-link"
              :class="{ 'bg-primary': isActiveMenuItem(menu.items.map(i => i.name)) }"
            >
              <i :class="['nav-icon', menu.icon]"></i>
              <p>
                {{ menu.label }}
                <i class="nav-arrow bi bi-chevron-right"></i>
              </p>
            </a>

            <ul class="nav nav-treeview">
              <li v-for="item in menu.items" :key="item.name" class="nav-item">
                <router-link :to="{ name: item.name }" class="nav-link">
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
    import { ref, computed, watch, reactive } from 'vue'
    import { useRoute } from 'vue-router'

    const route = useRoute()
    const openMenu = ref(null)
    const isOpen = ref(false)

    // --- Menu Configuration ---
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

    // --- Computed Helpers ---
    const isActiveMenuItem = computed(() => (items) => {
        return items.includes(route.name)
    })

    const isActiveMenu = computed(() => (menuName) => {
        return route.name?.startsWith(menuName)
    })

    // --- Toggle Sidebar Menu ---
    const toggleSidebar = (key) => {
        openMenu.value = openMenu.value === key ? null : key
    }

    // --- Auto Open Menu Based on Current Route ---
    watch(
        () => route.name,
        (name) => {
            if (['component', 'dashboard', 'dashboard-2', 'dashboard-3'].includes(name)) openMenu.value = 'dashboard'
            else if (['sample-tables', 'table-component'].includes(name)) openMenu.value = 'tables'
            else if (['cards', 'info-box', 'small-box'].includes(name)) openMenu.value = 'widgets'
            else if (['form'].includes(name)) openMenu.value = 'forms'
            else if (['general-ui', 'icon', 'timeline'].includes(name)) openMenu.value = 'ui'
        },
        { immediate: true } //to run on load too
    );


    // --- Counter ---
    const counter = ref(0)
    const increment = () => {
        counter.value++
    };

    watch(counter, () => {
        alert(counter.value)
    })
    // end counter

    //watch
    // watch(search, () => {})
    // watch(filters, () => {}, { deep: true })

</script>

<style scoped>
    .sidebar-wrapper {
    transition: all 0.3s ease;
    }

    .router-link-active {
    background-color: rgba(255, 255, 255, 0.9);
    color: #000 !important;
    }
</style>



                 
                <!-- <li class="nav-item">
                    <a href="#" class="nav-link">
                        <i class="nav-icon bi bi-clipboard-fill"></i>
                        <p>
                        Layout Options
                        <span class="nav-badge badge text-bg-secondary me-3">6</span>
                        <i class="nav-arrow bi bi-chevron-right"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                        <a href="./layout/unfixed-sidebar.html" class="nav-link">
                            <i class="nav-icon bi bi-circle"></i>
                            <p>Default Sidebar</p>
                        </a>
                        </li>
                        <li class="nav-item">
                        <a href="./layout/fixed-sidebar.html" class="nav-link">
                            <i class="nav-icon bi bi-circle"></i>
                            <p>Fixed Sidebar</p>
                        </a>
                        </li>
                        <li class="nav-item">
                        <a href="./layout/layout-custom-area.html" class="nav-link">
                            <i class="nav-icon bi bi-circle"></i>
                            <p>Layout <small>+ Custom Area </small></p>
                        </a>
                        </li>
                        <li class="nav-item">
                        <a href="./layout/sidebar-mini.html" class="nav-link">
                            <i class="nav-icon bi bi-circle"></i>
                            <p>Sidebar Mini</p>
                        </a>
                        </li>
                        <li class="nav-item">
                        <a href="./layout/collapsed-sidebar.html" class="nav-link">
                            <i class="nav-icon bi bi-circle"></i>
                            <p>Sidebar Mini <small>+ Collapsed</small></p>
                        </a>
                        </li>
                        <li class="nav-item">
                        <a href="./layout/logo-switch.html" class="nav-link">
                            <i class="nav-icon bi bi-circle"></i>
                            <p>Sidebar Mini <small>+ Logo Switch</small></p>
                        </a>
                        </li>
                        <li class="nav-item">
                        <a href="./layout/layout-rtl.html" class="nav-link">
                            <i class="nav-icon bi bi-circle"></i>
                            <p>Layout RTL</p>
                        </a>
                        </li>
                    </ul>
                </li> -->
             
              

                

               

                <!-- <li class="nav-header">EXAMPLES</li>
                <li class="nav-item">
                <a href="#" class="nav-link">
                    <i class="nav-icon bi bi-box-arrow-in-right"></i>
                    <p>
                    Auth
                    <i class="nav-arrow bi bi-chevron-right"></i>
                    </p>
                </a>
                <ul class="nav nav-treeview">
                    <li class="nav-item">
                    <a href="#" class="nav-link">
                        <i class="nav-icon bi bi-box-arrow-in-right"></i>
                        <p>
                        Version 1
                        <i class="nav-arrow bi bi-chevron-right"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                        <a href="./examples/login.html" class="nav-link">
                            <i class="nav-icon bi bi-circle"></i>
                            <p>Login</p>
                        </a>
                        </li>
                        <li class="nav-item">
                        <a href="./examples/register.html" class="nav-link">
                            <i class="nav-icon bi bi-circle"></i>
                            <p>Register</p>
                        </a>
                        </li>
                    </ul>
                    </li>
                    <li class="nav-item">
                    <a href="#" class="nav-link">
                        <i class="nav-icon bi bi-box-arrow-in-right"></i>
                        <p>
                        Version 2
                        <i class="nav-arrow bi bi-chevron-right"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                        <a href="./examples/login-v2.html" class="nav-link">
                            <i class="nav-icon bi bi-circle"></i>
                            <p>Login</p>
                        </a>
                        </li>
                        <li class="nav-item">
                        <a href="./examples/register-v2.html" class="nav-link">
                            <i class="nav-icon bi bi-circle"></i>
                            <p>Register</p>
                        </a>
                        </li>
                    </ul>
                    </li>
                    <li class="nav-item">
                    <a href="./examples/lockscreen.html" class="nav-link">
                        <i class="nav-icon bi bi-circle"></i>
                        <p>Lockscreen</p>
                    </a>
                    </li>
                </ul>
                </li>
                <li class="nav-header">DOCUMENTATIONS</li>
                <li class="nav-item">
                <a href="./docs/introduction.html" class="nav-link">
                    <i class="nav-icon bi bi-download"></i>
                    <p>Installation</p>
                </a>
                </li>
                <li class="nav-item">
                <a href="./docs/layout.html" class="nav-link">
                    <i class="nav-icon bi bi-grip-horizontal"></i>
                    <p>Layout</p>
                </a>
                </li>
                <li class="nav-item">
                <a href="./docs/color-mode.html" class="nav-link">
                    <i class="nav-icon bi bi-star-half"></i>
                    <p>Color Mode</p>
                </a>
                </li>
                <li class="nav-item">
                <a href="#" class="nav-link">
                    <i class="nav-icon bi bi-ui-checks-grid"></i>
                    <p>
                    Components
                    <i class="nav-arrow bi bi-chevron-right"></i>
                    </p>
                </a>
                <ul class="nav nav-treeview">
                    <li class="nav-item">
                    <a href="./docs/components/main-header.html" class="nav-link">
                        <i class="nav-icon bi bi-circle"></i>
                        <p>Main Header</p>
                    </a>
                    </li>
                    <li class="nav-item">
                    <a href="./docs/components/main-sidebar.html" class="nav-link">
                        <i class="nav-icon bi bi-circle"></i>
                        <p>Main Sidebar</p>
                    </a>
                    </li>
                </ul>
                </li>
                <li class="nav-item">
                <a href="#" class="nav-link">
                    <i class="nav-icon bi bi-filetype-js"></i>
                    <p>
                    Javascript
                    <i class="nav-arrow bi bi-chevron-right"></i>
                    </p>
                </a>
                <ul class="nav nav-treeview">
                    <li class="nav-item">
                    <a href="./docs/javascript/treeview.html" class="nav-link">
                        <i class="nav-icon bi bi-circle"></i>
                        <p>Treeview</p>
                    </a>
                    </li>
                </ul>
                </li>
                <li class="nav-item">
                <a href="./docs/browser-support.html" class="nav-link">
                    <i class="nav-icon bi bi-browser-edge"></i>
                    <p>Browser Support</p>
                </a>
                </li>
                <li class="nav-item">
                <a href="./docs/how-to-contribute.html" class="nav-link">
                    <i class="nav-icon bi bi-hand-thumbs-up-fill"></i>
                    <p>How To Contribute</p>
                </a>
                </li>
                <li class="nav-item">
                <a href="./docs/faq.html" class="nav-link">
                    <i class="nav-icon bi bi-question-circle-fill"></i>
                    <p>FAQ</p>
                </a>
                </li>
                <li class="nav-item">
                <a href="./docs/license.html" class="nav-link">
                    <i class="nav-icon bi bi-patch-check-fill"></i>
                    <p>License</p>
                </a>
                </li>
                <li class="nav-header">MULTI LEVEL EXAMPLE</li>
                <li class="nav-item">
                <a href="#" class="nav-link">
                    <i class="nav-icon bi bi-circle-fill"></i>
                    <p>Level 1</p>
                </a>
                </li> -->
<!--                 
                <li class="nav-item">
                    <a href="#" class="nav-link">
                        <i class="nav-icon bi bi-circle-fill"></i>
                        <p>
                        Level 1
                        <i class="nav-arrow bi bi-chevron-right"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                        <a href="#" class="nav-link">
                            <i class="nav-icon bi bi-circle"></i>
                            <p>Level 2</p>
                        </a>
                        </li>
                        <li class="nav-item">
                        <a href="#" class="nav-link">
                            <i class="nav-icon bi bi-circle"></i>
                            <p>
                            Level 2
                            <i class="nav-arrow bi bi-chevron-right"></i>
                            </p>
                        </a>
                        <ul class="nav nav-treeview">
                            <li class="nav-item">
                            <a href="#" class="nav-link">
                                <i class="nav-icon bi bi-record-circle-fill"></i>
                                <p>Level 3</p>
                            </a>
                            </li>
                            <li class="nav-item">
                            <a href="#" class="nav-link">
                                <i class="nav-icon bi bi-record-circle-fill"></i>
                                <p>Level 3</p>
                            </a>
                            </li>
                            <li class="nav-item">
                            <a href="#" class="nav-link">
                                <i class="nav-icon bi bi-record-circle-fill"></i>
                                <p>Level 3</p>
                            </a>
                            </li>
                        </ul>
                        </li>
                        <li class="nav-item">
                        <a href="#" class="nav-link">
                            <i class="nav-icon bi bi-circle"></i>
                            <p>Level 2</p>
                        </a>
                        </li>
                    </ul>
                </li> -->
                <!-- <li class="nav-item">
                    <a href="#" class="nav-link">
                        <i class="nav-icon bi bi-circle-fill"></i>
                        <p>Level 1</p>
                    </a>
                </li> -->

                <!-- <li class="nav-header">LABELS</li>
                <li class="nav-item">
                    <a href="#" class="nav-link">
                        <i class="nav-icon bi bi-circle text-danger"></i>
                        <p class="text">Important</p>
                    </a>
                </li>

                <li class="nav-item">
                    <a href="#" class="nav-link">
                        <i class="nav-icon bi bi-circle text-warning"></i>
                        <p>Warning</p>
                    </a>
                </li>

                <li class="nav-item">
                    <a href="#" class="nav-link">
                        <i class="nav-icon bi bi-circle text-info"></i>
                        <p>Informational</p>
                    </a>
                </li> -->
