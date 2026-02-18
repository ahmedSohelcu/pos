<template>
    <!--begin::Container-->
    <div class="container-fluid">        
      <div class="col-md-12">
      
        
        <div class="col-md-12 d-flex justify-content-center align-items-center">
          <BaseLoader v-if="form.loading" color="warning" />
        </div>

         <BaseTable
            :columns="columns"
            :rows="users"
            :last-page="meta.last_page"
            :actions="actions"
            :loading="form.loading"
            label="User Table"
            :filters="filters"
            @query-change="handleQuery"
        />

      </div>
    </div>
    
</template>


<script setup>

  import axios from 'axios';
  import { ref, reactive, onMounted } from 'vue'
  import { route } from 'ziggy-js'
  import router from '../../../../router';
  const selectedCategory = ref(2) // pre-selected by id 
  import { swalpopup, deleteWarning } from '../../../../ahmed-vue-kit/composables/useSweetAlert2';
  // const popup = swalpopup();  
  // popup.warning('Try again later');
  deleteWarning()

      // const confirmed = deleteWarning()
      // if (confirmed) {
      //     console.log(confirmed)
      //     // এখানে API call করো
      // } else {
      //     console.log(confirmed)
      // }


  /*
  |--------------------------------------------------------------------------
  | Query State (Single Source of Truth)
  |--------------------------------------------------------------------------
  */
  const query = ref({
      search: '',
      filters: {},
      perPage: 10,
      page: 1,
      category_id: null,
  })

  const meta = ref({
      last_page: 30
  })

  const loading = ref(false)


  /*
  |--------------------------------------------------------------------------
  | Handle Query From BaseTable
  |--------------------------------------------------------------------------
  */
  const handleQuery = (value) => {
      // 🔥 IMPORTANT: replace full query
      query.value = value
      console.log('Updated Query:', query.value)
      // fetchUsers()
  }
  /*
  |--------------------------------------------------------------------------
  | API Call
  |--------------------------------------------------------------------------
  */
  // const fetchUsers = async () => {

  //     loading.value = true

  //     try {
  //         const res = await axios.get('/api/users', {
  //             params: {
  //                 search: query.value.search,
  //                 page: query.value.page,
  //                 perPage: query.value.perPage,
  //                 ...query.value.filters
  //             }
  //         })

            // users.value = res.data.data
            // meta.value.last_page = res.data.last_page

  //     } catch (error) {
  //         console.error(error)
  //     }

  //     loading.value = false
  // }

  const form = reactive({
    name: 'Ahmed Ullah',
    email: 'ahmed@example.com',
    category: 2,
    description: 'Some text here...',
    agree: true,
    gender: 'male',
    loading: false,
  })

  const filters = [
    {
        name: 'status_id',
        label: 'Status',
        type: 'select',
        select2: true,          // 🔥 enable select2
        multiple: false,        // single select
        // options: [
        //     { id: 1, type: 'active'},
        //     { id: 2, type: 'inactive'},
        // ],
        getApiRoute: route('selectable_statuses'),
        // optionKeyName: 'type',
        // optionValueName: 'label'
    },
    {
        name: 'company_id',
        label: 'Company',
        type: 'select',
        select2: true,          // 🔥 enable select2
        multiple: true,         // 🔥 multiple select
        options: [
            { id: 1, name: 'Abc'},
            { id: 2, name: 'EFG'},
        ],
    },
    {
        name: 'created_at',
        label: 'Created At',
        type: 'time'
    },
    // {
    //     name: 'time',
    //     label: 'Time',
    //     type: 'time'
    // },
    // {
    //     name: 'Date',
    //     label: 'created At',
    //     type: 'datetime'
    // },
    // {
    //     name: 'date_range',
    //     label: 'Date Range',
    //     type: 'datetimerange'
    // },


      // Support types: date, time, datetime, datetimerange

  ];

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
        return "<button class='btn btn-sm btn-primary'>Ahmed Sohel</button>"
      },
      email: 'ahmed@test.com', 
      phone: '01545454545', 
      address: 'Hathazari, Chittagong',
    },      
    { 
      id: 2,
      name: 'Rayan Khan',
      email: 'rayan@test.com',
        phone: '01712345678',
        address: 'Dhaka'
      },
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



</script>