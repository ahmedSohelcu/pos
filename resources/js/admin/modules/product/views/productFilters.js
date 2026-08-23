export const productFilters = [
  {
    name: "is_active",
    label: "Status",
    type: "select",
    options: [
      { name: "Active", value: true },
      { name: "Inactive", value: false },
    ],
  },
  {
    name: "created_at",
    label: "Created At",
    type: "date",
  },
];