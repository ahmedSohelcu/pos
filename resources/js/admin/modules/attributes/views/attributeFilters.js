import { TENANT_ENDPOINTS } from '../../../../data/endpoint';

export const attributeFilters = [
  {
    name: 'is_active',
    label: 'Status',
    type: 'select',
    select2: true,
    multiple: false,
    options: [
      { id: 1, name: 'Active', value: 1 },
      { id: 2, name: 'Inactive', value: 0 },
    ],
    optionKeyName: 'name',
    optionValueName: 'value',
  },
  {
    name: 'tenant_id',
    label: 'Tenant',
    type: 'select',
    select2: true,
    multiple: false,
    getApiRoute: TENANT_ENDPOINTS.selectable,
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
