<template>
  <div class="container-fluid">
    <BaseTable
      label="Category Management"
      :columns="columns"
      :rows="categoryStore.rows"
      :loading="categoryStore.loading"
      :meta="categoryStore.meta"
      :filters="categoryFilters"
      :actions="categoryActions"
      @query-change="categoryStore.updateQuery"
      @create="createFromTableBtn"
      @refresh="categoryStore.fetchData"
      @bulk-delete="categoryStore.bulkDelete"
    />

    <BaseModal
      v-model="categoryStore.showModal"
      size="md"
      :loading="categoryStore.loading"
      confirmVariant="outline-success"
      cancelVariant="outline-danger"
      :centered="true"
      @confirm="createOrUpate"
      @close="closeModal"
      :title="categoryStore.mode === 'edit' ? 'Update Category' : 'Add New Category'"
      :confirmText="categoryStore.mode === 'edit' ? 'Update' : 'Create'"
    >
      <CategoryForm
        :model="categoryStore.selectedItem ?? {}"
        :errors="categoryStore.errors ?? {}"
      />
    </BaseModal>
  </div>
</template>

<script setup>
import { ref, reactive, computed, onMounted } from "vue";
import { categoryFilters } from "./categoryFilters";
import { getCategoryActions } from "./categoryActions";
// store
import { useCategoryStore } from "../store";
import BaseModal from "@kit/components/ui/BaseModal.vue";
import CategoryForm from "./CategoryForm.vue";
import { CATEGORY_ENDPOINTS } from "@/data/endpoint";

const categoryStore = useCategoryStore();

const closeModal = () => {
  categoryStore.loading = false;
};
// fetch data
onMounted(() => {
  categoryStore.fetchData();
});

//-------------------------
//load table actions button
//-------------------------
const categoryActions = getCategoryActions(categoryStore);

const columns = [
  {
    label: "#",
    custom: (row, index) => index + 1,
  },
  {
    name: "name",
    label: "Category Name",
    sortable: true,
    custom: (row) => `<span class="badge bg-success">${row.name}</span>`,
  },
  {
    name: "slug",
    label: "Slug",
    sortable: true,
    custom: (row) => row.slug ?? "",
  },
  {
    name: "tenant_id",
    label: "Tenant",
    sortable: true,
    custom: (row) => {
      return `<span class="text-primary">${row.tenant?.name ?? "-"}</span>`;
    },
  },
  {
    name: "status_id",
    label: "Status",
    sortable: true,
    custom: (row) => {
      return `<span class="text-light badge bg-${row.status?.class ?? ""}">${
        row.status?.name ?? "-"
      }</span>`;
    },
  },
  {
    name: "created_at",
    label: "Created At",
    sortable: true,
    custom: (row) => {
      return new Date(row.created_at).toLocaleString();
    },
  },
];

const createOrUpate = async () => {
  categoryStore.errors = {};
  if (categoryStore.mode === "edit") {
    await categoryStore.update(
      CATEGORY_ENDPOINTS.update(categoryStore.selectedItem.id),
      categoryStore.selectedItem
    );
  } else {
    await categoryStore.create(CATEGORY_ENDPOINTS.store, categoryStore.selectedItem);
  }
};

const createFromTableBtn = () => {
  categoryStore.mode = "create";
  categoryStore.errors = {};
  categoryStore.selectedItem = {};
  categoryStore.showModal = true;
};
</script>

<style scoped></style>
