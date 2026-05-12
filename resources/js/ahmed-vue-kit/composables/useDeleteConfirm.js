//----------------------------------
// Sweetalert2
//----------------------------------
import Swal from 'sweetalert2';

// -----------------------
// 01. Show Ok Dialog Box
// -----------------------
export const swalpopup = () => {
  return {
    success: (msg) => Swal.fire(msg, '', 'success'),
    error: (msg) => Swal.fire(msg, '', 'error'),
    info: (msg) => Swal.fire(msg, '', 'info'),
    warning: (msg) => Swal.fire(msg, '', 'warning'),
  };
};
//----------------------
// how to use
//----------------------
//   import { swalpopup, deleteWarning } from '../../../../ahmed-vue-kit/composables/useSweetAlert2';
//   const popup = swalpopup();
//   popup.warning('Try again later');

//----------------------------
// 02. Confirm Dialog with true false
//----------------------------

export const useDeleteConfirm = async (
  title = 'Are you sure To Delete?',
  text = 'This action cannot be undone!',
  confirmButtonText = 'Yes, delete it!',
  cancelButtonText = 'Cancel',
  icon = 'warning'
) => {
  const result = await Swal.fire({
    title,
    text,
    icon,
    showCancelButton: true,
    confirmButtonColor: '#dc3545',
    cancelButtonColor: '#6c757d',
    confirmButtonText,
    cancelButtonText,
  });

  return result.isConfirmed; // will return true or false
};

//----------------------
// how to use
//----------------------
// import { useDeleteConfirm } from '../../../../ahmed-vue-kit/composables/useDeleteConfirm';
// useDeleteConfirm()
//   .then((confirm) => {
//   if (confirm) {
//     alert(`Delete: ${row.name}`);
//   } else {
//     alert(`Cancel: ${row.name}`);
//   }
// });
