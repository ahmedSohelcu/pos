//----------------------------------
// Sweetalert2
//----------------------------------
import Swal from 'sweetalert2'

// 01
export const swalpopup = () => {
    return {
        success: (msg) => Swal.fire(msg, '', 'success'),
        error: (msg) => Swal.fire(msg, '', 'error'),
        info: (msg) => Swal.fire(msg, '', 'info'),
        warning: (msg) => Swal.fire(msg, '', 'warning'),
    }
}
//----------------------
// how to use
//----------------------
//   import { swalpopup, deleteWarning } from '../../../../ahmed-vue-kit/composables/useSweetAlert2';
//   const popup = swalpopup();  
//   popup.warning('Try again later');




// 02
export const deleteWarning = (
    title = 'Are you sure?',
    text = "This action cannot be undone!",
    confirmButtonText = 'Yes, delete it!',
    icon = 'warning',
    showCancelButton = true,
    confirmButtonColor = '#dc3545',
    cancelButtonColor = '#6c757d',
) => {
  Swal.fire({
    title,
    text,
    icon,
    showCancelButton,
    confirmButtonColor,
    cancelButtonColor,
    confirmButtonText
  })
  .then((result) => {
    if (result.isConfirmed) {
        return result.isConfirmed
    }
  })
}

//----------------------
// how to use
//----------------------
//   import { deleteWarning } from '../../../../ahmed-vue-kit/composables/useSweetAlert2';  
//   deleteWarning()


// import Swal from 'sweetalert2'
// const deleteUser = () => {
//   Swal.fire({
//     title: 'Are you sure?',
//     text: "This action cannot be undone!",
//     icon: 'warning',
//     showCancelButton: true,
//     confirmButtonColor: '#dc3545',
//     cancelButtonColor: '#6c757d',
//     confirmButtonText: 'Yes, delete it!'
//   }).then((result) => {
//     if (result.isConfirmed) {
//       console.log('Deleted!')
//     }
//   })
// }

