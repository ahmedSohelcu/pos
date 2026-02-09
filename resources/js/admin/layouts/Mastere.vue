
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

      <div class="row">          
          <div class="col">
            <BaseInput
              class="me-2"
              label="Name"      
              error=""
              placeholder="Enter your name"
              @update:modelValue="val => form.name = val"
            />
            <div class="me-2">{{ form.name }}</div>
          </div>

          <div class="col">
            <BaseSelect
              class="me-2"
              v-model="form.category"
              name="category_id"
              :getApiRoute="route('selectable_statuses')"
              label="Category"
              placeholder="Choose category"                          
            />
            <div class="me-2">{{ form.category }}</div>
          </div>

          <div class="col">
              <BaseSelect
                class="me-2"
                v-model="form.category"
                name="category_id"
                :options="categories"
                label="Country"
                multiple
                placeholder="Choose category"                                    
              />
              <div class="me-2">{{ form.category }}</div>

              
          </div>
     </div>
     <br>
     <br>
          
          

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

  import { ref, reactive } from 'vue'
import {  GET_SELECTABLE_STATUSES } from '../../ahmed-vue-kit/api/endpoint'
import { route } from 'ziggy-js'


const selectedCategory = ref(2) // pre-selected by id

  const form = reactive({
    name: 'Ahmed Ullah',
    email: 'ahmed@example.com',
    category: 2,
    description: 'Some text here...',
    agree: true,
    gender: 'male'
  })


  const categories = [
    { id: 1, name: 'Fruits' },
    { id: 2, name: 'Vegetables' },
    { id: 3, name: 'Dairy' },
    { id: 4, name: 'Meat' },
    { id: 5, name: 'Seafood' },
    { id: 6, name: 'Poultry' },
    { id: 7, name: 'Bakery' },
    { id: 8, name: 'Snacks' }
  ]

</script>