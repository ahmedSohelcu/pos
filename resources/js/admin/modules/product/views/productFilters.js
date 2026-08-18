import { STATUS_ENDPOINTS } from "../../../../data/endpoint";

export const productFilters = [
  {
    name: "status_id",
    label: "Status",
    type: "select",
    select2: true, // 🔥 enable select2
    multiple: false, // single select
    getApiRoute: STATUS_ENDPOINTS.selectable("common"),
    optionKeyName: "name",
    // optionValueName: 'label'
  },
  {
    name: "created_at",
    label: "Created At",
    type: "date",
  },
];