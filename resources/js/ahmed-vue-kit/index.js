import BaseInput from "./components/form/BaseInput.vue";
import BaseButton from "./components/ui/BaseButton.vue";
import BaseLoader from "./components/ui/BaseLoader.vue";
import BaseSelect from "./components/form/BaseSelect.vue";
import BaseDatePicker from "./components/form/BaseDatePicker.vue";
import BaseFilter from "./components/table/BaseFilter.vue";
import BaseCard from "./components/ui/BaseCard.vue";
import BaseForm from "./components/form/BaseForm.vue";
import BaseCheckbox from "./components/form/BaseCheckbox.vue";
import BaseRadio from "./components/form/BaseRadio.vue";
import BaseTable from "./components/table/BaseTable.vue";
import BaseTextarea from "./components/form/BaseTextarea.vue";
import BaseRichTextEditor from "./components/form/BaseRichTextEditor.vue";
import BaseShimmer from "./components/ui/BaseShimmer.vue";
// import BaseModal from "./components/ui/BaseModal.vue"; //use locally

export {
     BaseCard, //for manage card with title, body, footer left right or default submit button and footer text
     BaseFilter,
     BaseForm,
     BaseLoader,
     BaseTable,     
     
     BaseButton,
     BaseRadio,
     BaseCheckbox,
     BaseTextarea,     
     BaseInput, //for input type text, email, password, number, date, time,
     BaseSelect,
     BaseDatePicker, //for date, datetime, time, daterange, datetimerange,
     BaseRichTextEditor, // for rich text editor should import locally to use
     // BaseModal, //import locally     
     BaseShimmer
};


//---------------------------------------------
// Components which need to be imported locally
//-------------------------------------------- 
/*
 ** BaseFileUPload is in components/form/BaseFileUpload.vue
 ** BaseModal is in components/ui/BaseModal.vue
 ** BaseRichTextEditor is in components/form/BaseRichTextEditor.vue


//-----------------
// Other component
//-----------------
** Toastr is in componsables/useNotify.js // vue-toastification
** Sweetalert2 is in componsables/useSweetAlert2.js //sweetalert2
** buildFormData is in componsables/buildFormData.js to convert object to formdata


*/

//--------------
// To do  
//--------------
//placeholder for preloader
//badge

// table action button for print, export etc
//   Tabs
// sidebar menu make more flexible
// finally create package for ui components

//CartDrawer //OrderTimeline
