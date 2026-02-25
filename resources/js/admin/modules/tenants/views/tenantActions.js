export const tenantActions = [
  {
    label: 'View',
    handler: (row) => alert(`View: ${row.name}`),
  },
  {
    label: 'Edit',
    handler: (row) => {
      console.log('Edit:', row);
    },
  },
  {
    label: 'Delete',
    handler: (row) => alert(`Delete: ${row.name}`),
  },
  {
    label: (row) =>
      `Message <button class="btn btn-sm btn-warning">(${row.id})</button>`,
    handler: (row) => {
      console.log('Message clicked', row);
    },
  },
  {
    label: 'Go To Home',
    handler: (row) => {
      router.push('/');
    },
  },
];
