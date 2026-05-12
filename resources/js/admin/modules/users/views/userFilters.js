import { STATUS_ENDPOINTS } from "../../../../data/endpoint";

export const userFilters = [
  {
    name: 'status_id',
    label: 'Status',
    type: 'select',
    select2: true, // 🔥 enable select2
    multiple: false, // single select
    getApiRoute: STATUS_ENDPOINTS.selectable('common'),
    optionKeyName: 'name',
    // optionValueName: 'label'
  },
  {
    name: 'created_at',
    label: 'Created At',
    type: 'date',
  },
  // {
  //     name: 'time',
  //     label: 'Time',
  //     type: 'time'
  // },
  // {
  //     name: 'Date',
  //     label: 'created At',
  //     type: 'datetime'
  // },
  // {
  //   name: 'date_range',
  //   label: 'Date Range',
  //   type: 'datetimerange',
  // },
  // Support types: date, time, datetime, datetimerange
];
