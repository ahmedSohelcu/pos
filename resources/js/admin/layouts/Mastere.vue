
<template>
      <!--begin::App Wrapper-->
      <div class="app-wrapper">        
        <!-- header Navbar -->
        <Nav></Nav>
        <!--end header Navbar -->

        <!--begin::Sidebar-->
        <Sidebar></Sidebar>
        <!--end::Sidebar-->        

        <!--begin::App Main-->
        <main class="app-main">       
          <!--begin::Sidebar-->
          <Breadcumbs></Breadcumbs>
          <!--end::Sidebar-->

          <h2>Test Reusable Component</h2>

          <BaseInput
            label="Name"
            name="name"
            :modelValue="name"
            error="Please enter your name"
            placeholder="Enter your name"
            @update:modelValue="val => name = val"
          />

          {{ name ?? '' }}
          

          <!--begin::App Content-->
          <div class="app-content">             
            <router-view :key="$route.fullPath"/>           
          </div>
          <!--end::App Content-->
        </main>
        <!--end::App Main-->

        <!-- Footer component -->
        <Footer></Footer>         
        <!-- Footer component -->  
    </div>
    <!--end::App Wrapper-->
   
</template>
  
<script setup>
  import Nav from '../components/Nav.vue'
  import Sidebar from '../components/Sidebar.vue'
  import Footer from '../components/Footer.vue'
  import Breadcumbs from '../components/Breadcumbs.vue' 

  import { ref } from 'vue'

  const name = ref('')  
</script>