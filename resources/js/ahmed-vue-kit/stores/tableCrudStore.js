// tableCrudStore.js
import { defineStore } from 'pinia';
import api from '../api/api';
import { notify } from '../composables/useNotify';

export function tableCrudStore(name, endpoint) {
  return defineStore(name, {
    state: () => ({
      rows: [],
      loading: false,
      saving: false,
      selectedItem: null,
      mode: 'create', // create or edit
      errors: {},
      showModal: false,
      message: '',

      meta: {
        current_page: 1,
        last_page: 1,
        per_page: 10,
        total: 0,
        from: null,
        to: null,
      },

      query: {
        search: '',
        page: 1,
        perPage: 10,
        filters: {},
        sortColumn: null,
        sortDirection: null,
      },
    }),

    actions: {
      // 📥 Fetch List with debug logs
      async fetchData() {
        this.loading = true;
        try {
          console.log(`[${name}] Fetching data from endpoint:`, endpoint);
          console.log('Query params:', this.query);
          // alert(endpoint);
          const res = await api.get(endpoint, {
            params: {
              search: this.query.search,
              page: this.query.page,
              per_page: this.query.perPage,
              filters: this.query.filters,
              sort_column: this.query.sortColumn,
              sort_direction: this.query.sortDirection,
            },
          });
          // console.log(`[${name}] API Response:`, res.data);

          const apiData = res.data.data;

          this.rows = apiData.data;
          this.meta = {
            current_page: apiData.current_page,
            last_page: apiData.last_page,
            per_page: apiData.per_page,
            total: apiData.total,
            from: apiData.from,
            to: apiData.to,
          };
        } catch (error) {
          console.error(`[${name}] fetchData error:`, error);
          notify.error(
            error.response?.data?.message || 'Failed to fetch data.'
          );
        } finally {
          this.loading = false;
        }
      },

      // 👁 Show Single Item
      async show(endpoint) {
        this.loading = true;
        try {
          const res = await api.get(endpoint);
          console.log(`[${name}] show response:`, res.data);
          this.selectedItem = res.data.data;
          return this.selectedItem;
        } catch (error) {
          console.error(`[${name}] show error:`, error);
          notify.error(
            error.response?.data?.message || 'Failed to fetch item.'
          );
        } finally {
          this.loading = false;
        }
      },

      // ➕ Create
      async create(data) {
        this.saving = true;
        this.errors = {};
        try {
          const res = await api.post(endpoint, data);
          console.log(`[${name}] create response:`, res.data);
          await this.fetchData();
          this.showModal = false;
          notify.success(res.data.message || 'Created successfully.');
        } catch (error) {
          console.error(`[${name}] create error:`, error);
          if (error.response?.status === 422) {
            this.errors = error.response.data.errors;
          } else {
            this.message = error.response?.data?.message || 'Create failed.';
            notify.error(this.message);
          }
        } finally {
          this.saving = false;
        }
      },

      // ✏ Update
      async update(endpoint, data) {
        this.saving = true;
        this.errors = {};
        try {
          // const res = await api.put(`${endpoint}/${id}`, data);
          const res = await api.put(endpoint, data);
          console.log(`[${name}] update response:`, res.data);
          await this.fetchData();
          this.showModal = false;
          notify.success(res.data.message || 'Updated successfully.');
        } catch (error) {
          console.error(`[${name}] update error:`, error);
          if (error.response?.status === 422) {
            this.errors = error.response.data.errors;
          } else {
            this.message = error.response?.data?.message || 'Update failed.';
            notify.error(this.message);
          }
        } finally {
          this.saving = false;
        }
      },

      // 🗑 Delete
      async deleteRow(id) {
        try {
          const res = await api.delete(`${endpoint}/${id}`);
          console.log(`[${name}] delete response:`, res.data);
          this.rows = this.rows.filter((r) => r.id !== id);
          notify.success(res.data.message || 'Deleted successfully.');
        } catch (error) {
          console.error(`[${name}] delete error:`, error);
          notify.error(error.response?.data?.message || 'Delete failed.');
        }
      },

      // 🔄 Update query and fetch
      updateQuery(value) {
        this.query = value;
        this.fetchData();
      },

      // ♻ Reset state
      reset() {
        this.rows = [];
        this.selectedItem = null;
        this.errors = {};
      },
    },
  });
}
