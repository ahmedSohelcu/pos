import BaseInput from "./components/form/BaseInput.vue";
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

export {
     BaseCard, //for manage card with title, body, footer left right or default submit button and footer text
     BaseFilter,
     BaseForm,
     BaseLoader,
     BaseTable,     
     
     BaseRadio,
     BaseCheckbox,
     BaseTextarea,     
     BaseInput, //for input type text, email, password, number, date, time,
     BaseSelect,
     BaseDatePicker, //for date, datetime, time, daterange, datetimerange,
     BaseRichTextEditor, // for rich text editor should import locally to use
     
};


//--------------
// To do  
//--------------
//   file upload (single and multiple),
//   Modal
//   Tabs
// table action button for print, export etc
// sidebar menu make more flexible
// finally create package for ui components


//--------------
// Note
//--------------
//** Toastr is in componsables/useNotify.js
// ** Sweetalert2 is in componsables/useSweetAlert2.js