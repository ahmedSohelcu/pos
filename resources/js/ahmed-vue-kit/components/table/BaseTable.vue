<template>
    <!-- filter start -->
    <div class="container-fluid">
        <div class="card card-outline card-success mb-4">
            <div class="card-body">
                <div class="container-fluid">
                    <div class="row">              
                        <div class="col-md-12">
                            <h4 class="float-start mb-3">Filters Data</h4> 
                            <div class="float-end m-3">
                                <button type="button" class="btn btn-sm btn-warning text-dark btn-icon float-end me-2">
                                    <span class="btn-inner--icon">
                                        <i class="fas fa-download"></i>
                                    </span>
                                    <span class="btn-inner--text">&nbsp; Export Data</span>
                                </button>
                                
                                <button type="button" class="btn btn-sm btn-primary btn-icon float-end me-2">
                                    <span class="btn-inner--icon">
                                        <i class="fas fa-print"></i>
                                    </span>
                                    <span class="btn-inner--text">&nbsp; Print</span>
                                </button>
                            </div>
                        </div>

                        <div class="col-md-12">                          
                            <div class="mb-3 d-flex justify-content-between mb-2">                     
                                <div class="col me-3">
                                    <BaseSelect
                                        class="me-2"
                                        v-model="form.category"
                                        name="category_id"
                                        :getApiRoute="route('selectable_statuses')"
                                        label="Test"
                                        placeholder="Choose category"                          
                                    />
                                </div>  
                                
                                <div class="col me-3">
                                    <BaseSelect
                                        class="me-2"
                                        :modelValue="form.category"
                                        v-model="form.category"
                                        name="category_id"
                                        :getApiRoute="route('selectable_statuses')"
                                        label="Test"
                                        placeholder="Choose category"                          
                                    />
                                </div>  
                                
                                <div class="col me-3">
                                    <BaseSelect
                                        class="me-2"
                                        v-model="form.category"
                                        name="category_id"
                                        :getApiRoute="route('selectable_statuses')"
                                        label="Test"
                                        placeholder="Choose category"                          
                                    />
                                </div>  

                                <div class="col me-3">
                                    <BaseDatePicker 
                                        name="datetime_range"
                                        type="datetimerange" 
                                    />
                                </div>
                                

                                <div class="col me-3 mt-4">
                                    <button class="btn btn-primary w-100">
                                        Filter
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- filters end -->   

                                
<hr>
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
                            <div class="offset-md-2 col-md-3 ms-auto me-md-2">
                            <div class="input-group">
                                <input class="form-control customize-select" id="myInputDiv" 
                                    type="text" placeholder="Search..">                                                                                               
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

                            <tbody>
                                <tr v-for="(row, rowIndex) in data" :key="rowIndex" class="align-middle">
                                    <td v-for="(col, colIndex) in columns" :key="colIndex">{{ row[col.name] }}</td>
                                    
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
                                <tr v-if="data.length === 0">
                                    <td :colspan="columns.length + (actions.length ? 1 : 0)" class="text-center">No records found</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <!-- /.card-body -->          

                    <div class="card-footer clearfix">
                        <div class="d-flex justify-content-between">
                            <div>
                                <label>Show</label>
                                <select class="form-select" style="width: 100px; display: inline-block; margin-left: 5px;">
                                    <option>10</option>
                                    <option>25</option>
                                    <option>50</option>
                                    <option>100</option>
                                </select>
                                <label class="mr-2">entries</label>
                            </div>

                            <ul class="pagination pagination-sm m-0">
                                <li class="page-item"><a class="page-link" href="#">«</a></li>
                                <li class="page-item"><a class="page-link" href="#">1</a></li>
                                <li class="page-item"><a class="page-link" href="#">2</a></li>
                                <li class="page-item"><a class="page-link" href="#">3</a></li>
                                <li class="page-item"><a class="page-link" href="#">»</a></li>
                            </ul>
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
    import { ref, reactive } from 'vue'
    import { route } from 'ziggy-js'
    // import 'bootstrap/dist/css/bootstrap.min.css'

    const props = defineProps({
        label: {
            type: String,
            default: ''
        },
        rows: {
            type: Array,
            default: []
        },
        columns: {
            default: [],
            type: Array,
            required: true,
            // Example: [{ name: 'name', label: 'Name', width: '150px' }, ...]
        },
        data: {
            type: Array,
            required: true,
        },
        actions: {
            type: Array,
            default: () => [],
            // Example: [{ label: 'Edit', handler: (row) => console.log(row) }, ...]
        },
        actionLabel: {
            type: String,
            default: 'Action'
        },
        perPage: {
            type: Number,
            default: 3
        },
        loading: {
            type: Boolean,
            default: false
        }
        
    });

    const form = reactive({
        name: 'Ahmed Ullah',
        email: 'ahmed@example.com',
        category: null,
        description: 'Some text here...',
        agree: true,
        gender: 'male'
    });

    // onMounted(() => {
    //     picker = flatpickr(dateRangeRef.value, {
    //         mode: 'range',          // select start + end
    //         dateFormat: 'Y-m-d H:i', 
    //         enableTime: true,       // include time
    //         allowInput: true,       // allow typing if needed
    //         onChange: (selectedDates, dateStr) => {
    //         console.log('Selected range:', dateStr)
    //         // selectedDates = [startDate, endDate] as JS Date objects
    //         }
    //     })
    // })






</script>

<!--
// How to use
        <BaseTable
            :rows="rows"
            :columns="columns"
            :data="users"
            :actions="actions"
            :actionLabel="Action"
            :perPage="3"
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
        //-------------------------------------
        const users = [
            { id: 1, name: 'Ahmed Sohel', email: 'ahmed@test.com', phone: '01545454545', address: 'Hathazari, Chittagong' },
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

        //-------------------------------------
        //04. Support action label
        //-------------------------------------

-->
                            