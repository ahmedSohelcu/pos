<template>
    <!-- filter start -->
    <BaseFilter 
        v-if="filters.length" 
        :filters="filters"
        @filter-change="handleFilterChange"
    />
    <!-- filters end -->   
                               
    <!--begin::Container-->        
    <div class="container-fluid">
        <!--begin::Row-->
        <div class="row">      
            <div class="col-md-12">                          
                <!-- /.card -->
                <div class="card card-outline card-success mb-4">
                    <div class="card-header">
                        <h3 class="card-title p-2 ms-2 me-2">
                            {{ label || 'Table Heading' }}
                        </h3>

                        <div class="offset-md-2 col-md-4 ms-auto me-md-2">
                            <div class="row mb-2">
                                <div class="col">
                                    <button v-if="showPrintBtn !== false" type="button" class="btn btn-sm btn-primary btn-icon float-end me-2">
                                        <span class="btn-inner--icon">
                                            <i class="fas fa-print"></i>
                                        </span>
                                        <span class="btn-inner--text">&nbsp; Print</span>
                                    </button>

                                    <button v-if="showExportBtn !== false" type="button" class="btn btn-sm btn-warning text-dark btn-icon float-end me-2">
                                        <span class="btn-inner--icon">
                                            <i class="fas fa-download"></i>
                                        </span>
                                        <span class="btn-inner--text">&nbsp; Export Data</span>
                                    </button>                                    
                                </div>                                    
                            </div>

                            <div v-if="showSearch !== false" class="input-group">                                 
                                    <input
                                        v-model="search"
                                        class="form-control customize-select"
                                        type="text"
                                        placeholder="Search.."
                                    />                                                                                           
                            </div>      
                        </div>
                    </div>  


                    <!-- /.card-header -->                      
                    <div class="card-body p-0">          
                        <table class="table table-striped table-hover table-bordered">
                            <thead class="table-dark">
                                <tr>
                                    <th v-for="(col, index) in columns" :key="index" :style="{ width: col.width || 'auto' }">
                                        {{ col.label ?? '' }}
                                    </th>                                    
                                    <th v-if="actions.length">{{actionLabel}}</th>
                                </tr>
                            </thead>                           
                            <!-- table body data -->
                            <tbody>
                                <tr v-for="(row, rowIndex) in rows" :key="rowIndex" class="align-middle">                                 
                                   <td v-for="(col, colIndex) in columns" :key="colIndex">
                                        <span v-if="typeof row[col.name] === 'function'" v-html="row[col.name](row)"></span>
                                        <span v-else v-html="row[col.name]"></span>
                                    </td>
                           
                                    
                                    
                                    <td v-if="actions.length">
                                        <a href="" class="ddropdown-toggle badge text-light bg-info" data-bs-toggle="dropdown" aria-expanded="true"> 
                                            <i class="fa-solid fa-ellipsis-vertical"></i>     
                                        </a>
                                        <ul class="dropdown-menu">
                                            <li v-for="(action, i) in actions" :key="i">
                                                <a class="dropdown-item" href="#" @click.prevent="action.handler(row)">                                                    
                                                     <!-- HTML label support -->    
                                                    <span v-if="typeof action.label === 'string'" v-html="action.label"/>
                                                    <span v-else-if="typeof action.label === 'function'" v-html="action.label(row)"/>
                                                </a>
                                            </li>
                                            </ul>                                             
                                    </td>
                                </tr>
                                <tr v-if="rows.length === 0">
                                    <td :colspan="columns.length + (actions.length ? 1 : 0)" class="text-center">No records found</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <!-- /.card-body -->          

                    <div class="card-footer clearfix">
                        <div class="d-flex justify-content-between">

                            <!--Show number of entities for each table -->
                            <div>                            
                                <BaseTableEntities
                                    v-model="query.perPage"
                                />
                            </div>
                            
                            <!--table pagination  -->
                            <BaseTablePagination
                                v-model="query.page"
                                :last-page="lastPage"
                            />                        
                        </div>
                    </div>
                </div>
                <!-- /.card -->                               
            </div>
            <!-- /.col 12 -->
        </div>
        <!--end::Row-->
    </div>
    <!--end::Container-->
</template>

<script setup>
import { ref, reactive, watch } from 'vue'
import BaseTableEntities from './BaseTableEntities.vue'
import BaseTablePagination from './BaseTablePagination.vue'

/*
|--------------------------------------------------------------------------
| Props
|--------------------------------------------------------------------------
*/
const props = defineProps({
    label: String,
    rows: {
        type: Array,
        required: true
    },
    columns: {
        type: Array,
        required: true
    },
    filters: {
        type: Array,
        default: () => []
    },
    actions: {
        type: Array,
        default: () => []
    },
    actionLabel: {
        type: String,
        default: 'Action'
    },
    showSearch: {
        type: Boolean,
        default: true
    },
    showPrintBtn: {
        type: Boolean,
        default: true
    },
    showExportBtn: {
        type: Boolean,
        default: true
    },
    perPage: {
        type: Number,
        default: 10
    },
    page: {
        type: Number,
        default: 1
    },
    lastPage: {
        type: Number,
        default: 1
    }

})

/*
|--------------------------------------------------------------------------
| Emit
|--------------------------------------------------------------------------
*/
const emit = defineEmits(['query-change'])

/*
|--------------------------------------------------------------------------
| Single Query State
|--------------------------------------------------------------------------
*/
const query = reactive({
    search: '',
    filters: {},
    perPage: props.perPage,
    page: props.page
})

/*
|--------------------------------------------------------------------------
| Emit Automatically on Any Change
|--------------------------------------------------------------------------
*/
watch(
    query,
    () => {
        emit('query-change', { ...query })
    },
    { deep: true }
)

/*
|--------------------------------------------------------------------------
| Search (Debounce)
|--------------------------------------------------------------------------
*/
const search = ref('')
let debounceTimer = null

watch(search, (value) => {
    clearTimeout(debounceTimer)

    debounceTimer = setTimeout(() => {
        query.search = value
        query.page = 1
    }, 500)
})

/*
|--------------------------------------------------------------------------
| Handlers
|--------------------------------------------------------------------------
*/
const handleFilterChange = (filters) => {
    query.filters = filters
    query.page = 1
}
</script>

<!--
    1.table heading
    2.data 
    3.actions
    4.filers


// How to use
        <BaseTable
            :columns="columns"
            :rows="users"
            :perPage="3"
            :actions="actions"
            :loading="form.loading"
            label="User Table"
            :filters="filters"
            @query-change="handleQuery"
        />

        // Data
        //---------------------
        //01.  for table heading
        //---------------------
        // supports name,label and width

        const columns = [
            { name: 'id', label: '#', width: '10px' },
            { name: 'name', label: 'Name' },
            { name: 'email', label: 'Email' },
            { name: 'phone', label: 'Phone' },
            { name: 'address', label: 'Address' },
        ];


        //-------------------------------------
        //02. data without actions
        //supports function to render rows
        //-------------------------------------
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
            { id: 2, name: 'Rayan Khan', email: 'rayan@test.com', phone: '01712345678', address: 'Dhaka' },
        ];

        //-------------------------------------
        //03. action buttons with handler
        //-------------------------------------
            i. Action support label as Plain Text
            ii. Action support label as HTML
            iii. Action support label as Function and login

            const actions = [
            { 
                label: 'View', handler: (row) => alert(`View: ${row.name}`) 
            },
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
                    return   `Message <button class="btn btn-sm btn-warning">(${row.message})</button>`
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

        //04.Rename Action label 


        //-------------------------------------
        //05. Table filters
        //-------------------------------------
        
        const filters = [
            {
                name: 'status_id',
                label: 'Select Status',
                type: 'select',
                select2: true,
                multiple: false,        // single select
                options: [
                    { id: 1, type: 'active'},
                    { id: 2, type: 'inactive'},
                ],
                optionKeyName: 'type', //like name, type etc
            },
            {
                name: 'created_at',
                label: 'Created Date',
                type: 'date'
            },
        ];
        --------------------------
        ** select2: true,
            multiple: false
            only for type: select
        --------------------------

        
        //06. Support types for filtes are: date, time, datetime, datetimerange

        //define data for filter and serarch
          const query = ref({
            search: '',
            filters: {},
            perPage: 10,
            page: 1
        })
        /*
                //07. To hide search option (By default will show)
        ** :showSearch="false"

        //08. To hide print button
        ** :showPrintBtn="false"

        //09. To hide export button
        ** :showExportBtn="false"   


        // this will handle the query change for search, perPage and page, filters
        const handleQuery = (value) => {
            // 🔥 IMPORTANT: replace full query
            query.value = value
            console.log('Updated Query:', query.value)
            fetchUsers()
        }

-->
                            