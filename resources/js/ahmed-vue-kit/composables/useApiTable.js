import { ref } from 'vue';
import axios from 'axios';

export default function useApiTable(endpoint) {
  const rows = ref([]);
  const loading = ref(false);
  const meta = ref(null);

  const query = ref({
    search: '',
    page: 1,
    perPage: 10,
  });

  const fetchData = async () => {
    try {
        loading.value = true;
        const response = await axios.get(endpoint, {
        params: {
          search: query.value.search,
          page: query.value.page,
          per_page: query.value.perPage,
        },
      });

      const apiData = response.data.data;

      // 🔥 Auto detect pagination
      if (Array.isArray(apiData)) {
        // No pagination
        rows.value = apiData;
        meta.value = null;
      } else {
        // With pagination
        rows.value = apiData.data;
        meta.value = apiData;
      }
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
