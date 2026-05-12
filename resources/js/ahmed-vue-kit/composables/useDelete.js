// useDelete.js
import Swal from 'sweetalert2';
import axios from 'axios';
import { notify } from './useNotify';
import api from '../api/api';

/**
 * Reusable delete helper
 * @param {Object} options
 * @param {String} options.apiUrl - API endpoint (e.g., /api/tenants/:id)
 * @param {Function} options.onSuccess - Callback after successful deletion (optional)
 * @param {String} options.confirmTitle - Confirmation title
 * @param {String} options.confirmText - Confirmation text
 * @param {String} options.confirmButtonText - Button text
 */
export const confirmDelete = async ({
  apiUrl,
  onSuccess = null,
  confirmTitle = 'Are you sure?',
  confirmText = 'This action cannot be undone!',
  confirmButtonText = 'Yes, delete it!',
  icon = 'warning',
}) => {
  try {
    // 1️⃣ Show confirmation popup
    const result = await Swal.fire({
      title: confirmTitle,
      text: confirmText,
      icon,
      showCancelButton: true,
      confirmButtonColor: '#dc3545',
      cancelButtonColor: '#6c757d',
      confirmButtonText,
    });

    if (!result.isConfirmed) return false;
    // 2️⃣ Call delete API
    const res = await api.delete(apiUrl);

    // 3️⃣ Show success toast
    // Swal.fire('Deleted!', 'The record has been deleted.', 'success');

    notify.success(
      res?.data?.message ?? 'Deleted! The record has been deleted.'
    );
    // notify.success('Deleted! The record has been deleted.');

    // 4️⃣ Callback if provided
    if (onSuccess && typeof onSuccess === 'function') onSuccess();

    return true;
  } catch (err) {
    console.error('Delete error:', err);
    // Swal.fire('Error!', err.response?.data?.message || err.message, 'error');
    notify.error('Error!', err.response?.data?.message || err.message, 'error');

    return false;
  }
};

// How to use
// import { confirmDelete } from '@/composables/useDelete'
// export const tenantActions = [
//   {
//     label: 'Delete',
//     handler: async (row) => {
//       await confirmDelete({
//         apiUrl: `/api/v1/tenants/${row.id}`,
//         onSuccess: () => {
//           fetchData() // refresh table after delete
//         },
//         confirmTitle: `Delete ${row.name}?`,
//       })
//     },
//   },
// ]
