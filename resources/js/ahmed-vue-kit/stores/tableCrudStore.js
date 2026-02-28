import { defineStore } from 'pinia';
import axios from 'axios';
import { notify } from '../composables/useNotify';

export function tableCrudStore(name, endpoint) {
  return defineStore(name, {
    state: () => ({
      rows: [],
      loading: false,
      saving: false,
      selectedItem: {},
      mode: 'create', //create or edit
      errors: {}, // ✅ validation errors from Laravel
      showModal: false,
      message: '',
      countries: [
        {
          id: 1,
          name: 'Egypt',
        },
        {
          id: 2,
          name: 'Saudi Arabia',
        },
      ],

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
      async fetchData() {
        try {
          this.loading = true;

          const res = await axios.get(endpoint, {
            params: {
              search: this.query.search,
              page: this.query.page,
              per_page: this.query.perPage,
              filters: this.query.filters,
              sort_column: this.query.sortColumn,
              sort_direction: this.query.sortDirection,
            },
          });

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
        } finally {
          this.loading = false;
        }
      },

      async show(id, endpoint) {
        this.loading = true;
        try {
          const res = await axios.get(`${endpoint}/${id}`);
          this.selectedItem = res.data.data;
        } finally {
          this.loading = false;
        }
      },

      async create(endpoint, data) {
        this.saving = true;
        this.errors = {}; // clear old errors
        try {
          const res = await axios.post(endpoint, data);
          await this.fetchData();
          this.showModal = false; // close only on success
          notify.success(res.data.message);
        } catch (error) {
          if (error.response?.status === 422) {
            this.errors = error.response.data.errors;
          } else {
            console.error(error);
          }
        } finally {
          this.saving = false;
        }
      },

      async update(endpoint, data) {
        this.saving = true;
        this.errors = {};

        try {
          const res = await axios.put(endpoint, data);
          await this.fetchData();
          this.showModal = false;
          notify.success(res.data.message);
        } catch (error) {
          if (error.response?.status === 422) {
            this.errors = error.response.data.errors;
            this.message = String(error.response.data.message);
          } else {
            this.message = String(error.response.data.message);
            notify.error(this.message);
          }
        } finally {
          this.saving = false;
        }
      },

      async deleteRow(id) {
        await axios.delete(`${endpoint}/${id}`);
        this.rows = this.rows.filter((r) => r.id !== id);
      },

      updateQuery(value) {
        this.query = value;
        this.fetchData();
      },

      reset() {
        this.rows = [];
        this.selectedItem = null;
      },
    },
  });
}
