// https://vue-toastification.maronato.dev/

import { useToast } from "vue-toastification"

export function useNotify() {
    const toast = useToast()

    return {
        success: (msg) => toast.success(msg),
        error: (msg) => toast.error(msg),
        info: (msg) => toast.info(msg),
        warning: (msg) => toast.warning(msg),
    }
}

//----------------
// How To Use
//----------------

//---------------------
// 01
//---------------------
// import  { useNotify }  from "@/ahmed-vue-kit/composables/userNotify";
// const { success, error, info, warning } = useNotify();
// success("Success Message");
// error("Error Message");
// info("Info Message");
// warning("Warning Message");

//---------------------
// 02
//---------------------
// import  { useNotify }  from "@/ahmed-vue-kit/composables/userNotify";
// const toast = useNotify();
// toast.success("Success Message");