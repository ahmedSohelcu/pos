<template>
  <!-- Filters -->
  <BaseFilter
    v-if="filters.length"
    :filters="filters"
    @filter-change="handleFilterChange"
    class="mb-3"
  />

  <div class="card table-card border-0">

    <!-- ================= HEADER ================= -->
    <div class="card-header table-header-pro border-0">

      <div class="d-flex justify-content-between align-items-center flex-wrap gap-3">

        <!-- LEFT: Search & Title -->
        <div class="d-flex align-items-center gap-3 flex-wrap">         

          <!-- Table Title & Info -->
          <div>
                <h5 class="mb-1 fw-bold table-title">{{ label || 'Data Management' }}</h5>
                <div class="table-subtitle">
                    <span class="me-3">Total: <strong>{{ rows.length }}</strong></span>
                    <span v-if="selectedRows.length" class="text-primary fw-semibold">
                        Selected: {{ selectedRows.length }}
                    </span>
                </div>
          </div>          
        </div>
        

        <!-- RIGHT: Actions -->
        <div class="d-flex align-items-center gap-2 flex-wrap">
        
           <!-- Search Input -->
          <div v-if="showSearch" class="search-wrapper">
                <i class="fas fa-search search-icon"></i>
                <input v-model="search" type="text" placeholder="Search records..." />
          </div>

          <!-- Primary Action -->
          <button class="btn btn-sm btn-primary px-3" @click="$emit('create')">
            <i class="fas fa-plus me-1"></i> New
          </button>

          <!-- Refresh -->
          <button class="btn btn-sm btn-light border" @click="$emit('refresh')">
            <i class="fas fa-rotate-right"></i>
          </button>

          <!-- Column Toggle -->
          <div class="dropdown">
            <button class="btn btn-sm btn-light border" data-bs-toggle="dropdown">
              <i class="fas fa-columns"></i>
            </button>
            <ul class="dropdown-menu dropdown-menu-end shadow-sm p-2">
              <li v-for="(col,i) in columns" :key="i">
                <label class="dropdown-item small">
                  <input
                    type="checkbox"
                    class="me-2"
                    :checked="visibleColumns.includes(col)"
                    @change="toggleColumn(col)"
                  />
                  {{ col.label }}
                </label>
              </li>
            </ul>
          </div>

          <!-- Export / Print -->
          <div class="btn-group btn-group-sm">
            <button class="btn btn-outline-primary me-1" @click="$emit('export-pdf')">
              <i class="fas fa-file-pdf me-1"></i> PDF
            </button>
            <button class="btn btn-outline-success me-1" @click="$emit('export-csv')">
              <i class="fas fa-file-csv me-1"></i> CSV
            </button>
            <button class="btn btn-outline-warning me-1" @click="$emit('print')">
              <i class="fas fa-print me-1"></i> Print
            </button>
          </div>

        </div>
      </div>
    </div>

    <!-- ================= BODY ================= -->
    <div class="card-body p-0 position-relative">

      <!-- Loading Overlay -->
      <div v-if="loading" class="table-loading-overlay">
        <div class="spinner-border text-primary"></div>
      </div>

      <div class="table-responsive table-wrapper">
        <table class="table table-hover align-middle mb-0 modern-table">
          <thead>
            <tr>
              <!-- Select All -->
              <th style="width:40px">
                <input
                  type="checkbox"
                  @change="toggleSelectAll"
                  :checked="selectedRows.length === rows.length && rows.length"
                />
              </th>

              <!-- Columns -->
              <th
                v-for="(col,index) in visibleColumns"
                :key="index"
                @click="handleSort(col)"
                :class="['text-nowrap', col.sortable ? 'cursor-pointer user-select-none' : '']"
              >
                {{ col.label }}
                <span v-if="col.sortable && sort.column === col.name">
                  <i v-if="sort.direction==='asc'" class="fas fa-sort-up ms-1"></i>
                  <i v-else class="fas fa-sort-down ms-1"></i>
                </span>
              </th>

              <!-- Actions -->
              <th v-if="actions.length" class="text-center" style="width:60px;">
                {{ actionLabel }}
              </th>
            </tr>
          </thead>

          <tbody>
            <tr v-for="(row,rowIndex) in rows" :key="rowIndex">

              <!-- Checkbox -->
              <td>
                <input type="checkbox" :value="row" v-model="selectedRows" />
              </td>

              <!-- Data -->
              <td v-for="(col,i) in visibleColumns" :key="i">
                <span v-if="typeof row[col.name] === 'function'" v-html="row[col.name](row)"></span>
                <span v-else v-html="row[col.name]"></span>
              </td>

              <!-- Actions Dropdown -->
              <td v-if="actions.length" class="text-center">
                <div class="dropdown">
                  <button class="btn btn-sm btn-light" data-bs-toggle="dropdown">
                    <i class="fa-solid fa-ellipsis-vertical"></i>
                  </button>
                  <ul class="dropdown-menu dropdown-menu-end shadow-sm">
                    <li v-for="(action,i) in actions" :key="i">
                      <a class="dropdown-item" href="#" @click.prevent="action.handler(row)">
                        <span v-if="typeof action.label==='string'" v-html="action.label"></span>
                        <span v-else v-html="action.label(row)"></span>
                      </a>
                    </li>
                  </ul>
                </div>
              </td>

            </tr>

            <!-- Empty -->
            <tr v-if="!loading && rows.length===0">
              <td :colspan="visibleColumns.length + 2" class="text-center py-5 text-muted empty-state">
                <i class="fas fa-database fa-2x mb-2 d-block opacity-50"></i>
                No records available
              </td>
            </tr>

          </tbody>
        </table>
      </div>
    </div>

    <!-- ================= FOOTER ================= -->
    <div class="card-footer bg-white border-0">
      <div class="d-flex justify-content-between align-items-center">
        <BaseTableEntities v-model="query.perPage" />
        <BaseTablePagination v-model="query.page" :last-page="lastPage" />
      </div>
    </div>

  </div>
</template>

<script setup>
import { ref, reactive, watch } from 'vue'
import BaseTableEntities from './BaseTableEntities.vue'
import BaseTablePagination from './BaseTablePagination.vue'

/* ================= PROPS ================= */
const props = defineProps({
  label: String,
  rows: { type: Array, required: true },
  columns: { type: Array, required: true },
  filters: { type: Array, default: () => [] },
  actions: { type: Array, default: () => [] },
  actionLabel: { type: String, default: 'Action' },
  loading: { type: Boolean, default: false },
  showSearch: { type: Boolean, default: true },
  perPage: { type: Number, default: 10 },
  page: { type: Number, default: 1 },
  lastPage: { type: Number, default: 1 }
})

/* ================= EMITS ================= */
const emit = defineEmits([
  'query-change', 
  'bulk-delete', 
  'create', 
  'refresh',
  'export-pdf', 
  'export-csv', 
  'print'
])

/* ================= STATE ================= */
const query = reactive({
  search: '',
  filters: {},
  perPage: props.perPage,
  page: props.page
})
const sort = reactive({ column: null, direction: null })
const visibleColumns = ref([...props.columns])
const selectedRows = ref([])
const search = ref('')
let debounce = null

/* ================= WATCHERS ================= */
watch([query, sort], () => {
  emit('query-change', {
    ...query,
    sortColumn: sort.column,
    sortDirection: sort.direction
  })
}, { deep: true })

watch(search, (val) => {
  clearTimeout(debounce)
  debounce = setTimeout(() => {
    query.search = val
    query.page = 1
  }, 400)
})

/* ================= METHODS ================= */
const handleFilterChange = (filters) => { query.filters = filters; query.page = 1 }
const handleSort = (col) => {
  if (!col.sortable) return
  sort.column = sort.column !== col.name ? col.name : sort.column
  sort.direction = sort.column !== col.name ? 'asc' : sort.direction === 'asc' ? 'desc' : 'asc'
}
const toggleSelectAll = (e) => { selectedRows.value = e.target.checked ? [...props.rows] : [] }
const toggleColumn = (col) => {
  visibleColumns.value = visibleColumns.value.includes(col)
    ? visibleColumns.value.filter(c => c !== col)
    : [...visibleColumns.value, col]
}
</script>

<style scoped>
/* 🔥 FIX: allow dropdown to overflow table */
.table-wrapper {
  overflow: visible !important;
}

/* 🔥 FIX: dropdown above modal backdrop */
.dropdown-menu {
  z-index: 2000 !important;
}

/* 🔥 FIX: table card stacking context */
.table-card {
  position: relative;
  z-index: 1;
}

/* CARD */
.table-card{ border-radius:10px; box-shadow:0 4px 12px rgba(0,0,0,.04); }

/* HEADER */
.table-header-pro{ background:#fff; padding:16px 20px; border-bottom:1px solid #f1f3f5; }
.table-title{ font-size:15px; letter-spacing:.3px; }
.table-subtitle{ font-size:12px; color:#6c757d; }

/* SEARCH */
.search-wrapper{ position:relative; }
.search-wrapper input{
  height:32px; padding:0 12px 0 32px; border:1px solid #e5e7eb; border-radius:6px;
  font-size:13px; width:220px; transition:all .2s ease;
}
.search-wrapper input:focus{ outline:none; border-color:#6366f1; box-shadow:0 0 0 2px rgba(99,102,241,.1); }
.search-icon{ position:absolute; left:10px; top:50%; transform:translateY(-50%); font-size:12px; color:#9ca3af; }

/* TABLE BODY */
.table-wrapper{ max-height:500px; overflow:auto; }
.modern-table thead th{
  position:sticky; top:0; background:#fff; z-index:5;
  font-size:12px; text-transform:uppercase; letter-spacing:.5px; color:#6b7280;
}
.empty-state{ font-size:13px; }
.table-loading-overlay{
  position:absolute; inset:0; background:rgba(255,255,255,.6);
  display:flex; align-items:center; justify-content:center; z-index:10;
}
.cursor-pointer{ cursor:pointer; }

</style>
<!--
    1.table heading
    2.data 
    3.actions
    4.filers


// How to use
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

        // Data
        //---------------------
        //01.  for table heading
        //---------------------
        // supports name,label and width

        const columns = [
        { name: 'id', label: 'ID', sortable: true },
        { name: 'name', label: 'Name', sortable: true },
        { name: 'email', label: 'Email', sortable: true },
        { name: 'role', label: 'Role', sortable: true },
        { name: 'status', label: 'Status', sortable: true },
        ]


        //-------------------------------------
        //02. data without actions
        //supports function to render rows
        //-------------------------------------
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
                            




