<template>
    <!--begin::Container-->
    <div class="container-fluid">        
      <div class="col-md-12">
      
        
        <div class="col-md-12 d-flex justify-content-center align-items-center">
          <BaseLoader v-if="form.loading" color="warning" />
        </div>

        <BaseTable
            :data="users"
            :columns="columns"
            :perPage="3"
            :actions="actions"
            :loading="form.loading"
            label="User Table"
        />
      </div>
    </div><!--end::Container-->
</template>


<script setup>

import { ref, reactive } from 'vue'
import { route } from 'ziggy-js'
import router from '../../../../router';
import { h } from 'vue'



const selectedCategory = ref(2) // pre-selected by id

  const form = reactive({
    name: 'Ahmed Ullah',
    email: 'ahmed@example.com',
    category: 2,
    description: 'Some text here...',
    agree: true,
    gender: 'male',
    loading: false
  })



//  for table
const columns = [
  { name: 'id', label: '#', width: '10px' },
  { name: 'name', label: 'Name' },
  { name: 'email', label: 'Email' },
  { name: 'phone', label: 'Phone' },
  { name: 'address', label: 'Address' },
];

const users = [
  { 
    id: 1,
    name: (row) => {
      return "<button class='btn btn-sm btn-primary'>Ahmed Sohel</button>";
    },
    email: 'ahmed@test.com', 
    phone: '01545454545', 
    address: 'Hathazari, Chittagong'
  },
  { id: 2, name: 'Rayan Khan', email: 'rayan@test.com', phone: '01712345678', address: 'Dhaka'},
];

const actions = [
    { label: 'View', handler: (row) => alert(`View: ${row.name}`) },
    { 
      label: 'Edit', handler: (row) => {
        form.loading = false;
      } 
    },
    { 
      label: 'Delete', handler: (row) => alert(`Delete: ${row.name}`) 
    },
    {       
      label: (row) => {
          return   `Message <button class="btn btn-sm btn-warning">(${row.id})</button>`
      },
      handler: (row) => {
        form.loading = true;
      } 
    },
    { 
      label: 'Go To Home',
      handler: (row) => {
        router.push('/')
      } 
    }
];

const actions2 = [
     { 
    label: 'Message (5)',
    handler: (row) => alert(`Message for ${row.name}`),
    show: (row) => row.hasMessages && row.hasMessages > 0, // only show if row.hasMessages > 0
  },
  { 
    label: 'Edit',
    handler: (row) => alert(`Edit ${row.name}`),
    show: true, // always show
  }, 
];

</script>