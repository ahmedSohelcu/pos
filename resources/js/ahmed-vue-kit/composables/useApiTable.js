import { ref } from 'vue';
import axios from 'axios';

export default function useApiTable(endpoint) {
  const rows = ref([]);
  const loading = ref(false);

  // 🔥 Pagination meta (separate state)
  const meta = ref({
    current_page: 1,
    last_page: 1,
    per_page: 10,
    total: 0,
    from: null,
    to: null,
  });

  const query = ref({
    search: '',
    page: 1,
    perPage: 10,
    filters: {},
    sortColumn: null,
    sortDirection: null,
  });

  const fetchData = async () => {    
    try {
      loading.value = true;
      const response = await axios.get(endpoint, {
        params: {
          search: query.value.search,
          page: query.value.page,
          per_page: query.value.perPage,
          filters: query.value.filters,
          sort_column: query.value.sortColumn,
          sort_direction: query.value.sortDirection,
        },
      });

      const apiData = response.data.data;

      // 🔥 If not paginated
      if (Array.isArray(apiData)) {
        rows.value = apiData;

        meta.value = {
          current_page: 1,
          last_page: 1,
          per_page: apiData.length,
          total: apiData.length,
          from: 1,
          to: apiData.length,
        };
      }
      // 🔥 If paginated
      else {
        rows.value = apiData.data;

        meta.value = {
          current_page: apiData.current_page,
          last_page: apiData.last_page,
          per_page: apiData.per_page,
          total: apiData.total,
          from: apiData.from,
          to: apiData.to,
        };
      }

      console.log('Meta:', meta.value);
    } catch (error) {
      console.error('API Error:', error);
    } finally {
      loading.value = false;
    }
  };

  const handleQueryChange = (value) => {
    query.value = value;
    fetchData();
  };

  return {
    query,
    rows,
    loading,
    meta,
    fetchData,
    handleQueryChange,
  };
}


//------------------
// How to use
//------------------
{/* <template>
  <div class="container-fluid">
    <BaseTable
      label="User Management"
      :columns="columns"
      :rows="rows"
      :show-search="true"
      :actions="tenantActions"
      :filters="tenantFilters"
      :meta="meta"
      @query-change="handleQueryChange"
    />
  </div>
</template>
<script setup>
import { ref, reactive, computed, onMounted } from 'vue';
import useApiTable from '../../../../ahmed-vue-kit/composables/useApiTable';
import { tenantFilters } from './tenantFilters';

const { query, rows, loading, meta, fetchData, handleQueryChange } =
  useApiTable('http://lara-vue-admin.test/api/v1/tenants');

import { getTenantActions } from './tenantActions';
const tenantActions = getTenantActions(fetchData);

onMounted(async () => {
  await fetchData();
});

const columns = [
  { name: 'id', label: 'ID', sortable: true },
  {
    name: 'name',
    label: 'Shop Name',
    sortable: true,
    custom: (row) => `<span class="badge bg-success">${row.name}</span>`,
  },
  {
    name: 'email',
    label: 'Email',
    sortable: true,
  },
];
</script> */}