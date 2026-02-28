// https://vue-toastification.maronato.dev/

import { useToast } from 'vue-toastification';

const toast = useToast();

export const notify = {
  success: (msg) => toast.success(msg),
  error: (msg) => toast.error(msg),
  info: (msg) => toast.info(msg),
  warning: (msg) => toast.warning(msg),
};

//----------------
// How To Use
//----------------

//---------------------
// 01
//---------------------
// import { notify } from './useNotify';
// notify.success('Deleted! The record has been deleted.');

//---------------------
// 02
//---------------------
// import { notify } from './useNotify';
// const { success, error, info, warning } = notify;
// success("Success Message");
// error("Error Message");
// info("Info Message");
// warning("Warning Message");
