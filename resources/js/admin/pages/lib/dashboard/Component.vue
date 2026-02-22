<template>
    <!--begin::Container-->
    <div class="container-fluid">        
      <div class="col-md-12">      
        
        <button class="btn btn-danger" @click="showModal = true">
          Show Modal
        </button>
 <br>
 <br>
       <BaseModal v-model="showModal" title="Create User" size="lg">  
          <form @submit.prevent="saveUser">
            <input class="form-control mb-2" v-model="form.name" placeholder="Name">
            <input class="form-control" v-model="form.email" placeholder="Email">
          </form>

          <template #footer>
            <button class="btn btn-secondary" @click="showModal = false">
              Cancel
            </button>

            <button class="btn btn-success" @click="saveUser">
              Save
            </button>
          </template>
      </BaseModal>

    
        <div class="col-md-12 d-flex justify-content-center align-items-center">
          <BaseLoader v-if="form.loading" color="warning" />
        </div>

         <BaseTable
            :last-page="meta.last_page"
            :loading="form.loading"
            @query-change="handleQuery"
            label="User Management"
            :columns="columns"
            :rows="users"
            :actions="actions"
            :filters="filters"
            :show-search="true"
            @create="alert('Create new user')"
            @refresh="alert('Refresh table')"
            @bulk-delete="(selected)=>alert('Delete bulk: ' + selected.map(r=>r.name).join(', '))"
        />

      </div>
    </div>
    
</template>


<script setup>

  import axios from 'axios';
  import { ref, reactive, onMounted } from 'vue'
  import { route } from 'ziggy-js'
  import router from '../../../../router';
  import { swalpopup, deleteWarning } from '../../../../ahmed-vue-kit/composables/useSweetAlert2';
  
  import BaseModal from '../../../../ahmed-vue-kit/components/ui/BaseModal.vue';
  const showModal = ref(false)



  const selectedCategory = ref(2) // pre-selected by id 
  
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
  { name: 'id', label: 'ID', sortable: true },
  { name: 'name', label: 'Name', sortable: true },
  { name: 'email', label: 'Email', sortable: true },
  { name: 'role', label: 'Role', sortable: true },
  { name: 'status', label: 'Status', sortable: true },
]

  const users = [
    { 
      id: 1,
      name: (row) => {
        return "<button class='btn btn-sm btn-primary'>Ahmed Sohel</button>"
      },
       email: 'ahmed@example.com', role: 'Admin', status: 'Active' 
    },
    { id: 2, name: 'Rayan Khan', email: 'rayan@example.com', role: 'User', status: 'Inactive' },
    { id: 3, name: 'Sara Ali', email: 'sara@example.com', role: 'Moderator', status: 'Active' },
    { id: 4, name: 'John Doe', email: 'john@example.com', role: 'User', status: 'Active' },
    { id: 5, name: 'Jane Smith', email: 'jane@example.com', role: 'User', status: 'Inactive' }
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


  // 
      const saveUser= ()=>{
        alert('Deleted!')
      }


</script>