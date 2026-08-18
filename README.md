# 🚀 Laravel + Vue Reusable UI Components

A modern **Vue 3 component library** built specifically for **Laravel projects** to create reusable, scalable, and maintainable UI faster.

This project helps you avoid rewriting the same inputs, tables, modals, and forms in every project.

---

## ✨ Tech Stack

- Laravel 10+
- Vue 3 (Composition API)
- Pinia (State Management)
- Bootstrap 5
- Axios
- Vite

---

## 🎯 Goals

✅ Reusable components  
✅ Clean architecture  
✅ DRY codebase  
✅ Faster development  
✅ Consistent UI  
✅ Easy customization  

---

## 📦 Included Components

### 🧩 Form Components
- Input (text, number, email, password)
- Textarea
- Select / Multi-select
- Checkbox
- Radio
- File Upload
- Date / Datetime picker
- Validation helpers

### 🎨 UI Components
- Button
- Card
- Badge
- Alert
- Toast
- Loader / Spinner
- Modal / Dialog
- Tabs

### 📊 Data Components
- Table
- Search
- Filter
- Pagination
- Sorting
- Server-side support

---

## 📁 Project Structure

```bash
resources/
 ├── js/
 │   ├── components/
 │   │   ├── ui/
 │   │   │   ├── inputs/
 │   │   │   ├── table/
 │   │   │   ├── modal/
 │   │   │   └── common/
 │   │   ├── layouts/
 │   │   ├── pages/
 │   │   └── store/
 │   ├── composables/
 │   ├── app.js
 │   └── bootstrap.js
```

---

## ⚙️ Installation

### 1. Clone project

```bash
git clone https://github.com/yourname/laravel-vue-components.git
cd laravel-vue-components
```

### 2. Install dependencies

```bash
composer install
npm install
```

### 3. Run project

```bash
php artisan serve
npm run dev
```

---

## 🔌 Vue Setup

### resources/js/app.js

```javascript
import { createApp } from "vue";
import { createPinia } from "pinia";
import App from "./App.vue";

const app = createApp(App);

app.use(createPinia());

app.mount("#app");
```

---

## 🧩 Usage Examples

---

### ✅ Input Component

```vue
<UiInput
  label="Name"
  v-model="form.name"
  placeholder="Enter your name"
/>
```

---

### ✅ Select Component

```vue
<UiSelect
  v-model="form.role"
  :options="roles"
/>
```

```javascript
const roles = [
  { label: "Admin", value: 1 },
  { label: "User", value: 2 }
];
```

---

### ✅ Modal Component

```vue
<UiModal v-model="showModal" title="Create User">
  <p>Modal content here</p>
</UiModal>
```

---

### ✅ Table Component

```vue
<UiTable
  :columns="columns"
  :rows="users"
  searchable
  pagination
/>
```

```javascript
const columns = [
  { label: "Name", key: "name" },
  { label: "Email", key: "email" }
];
```

---

## 🌍 Global Registration (Optional)

```javascript
import * as components from "./components/ui";

Object.entries(components).forEach(([name, component]) => {
  app.component(name, component);
});
```

Now use anywhere:

```vue
<UiInput />
<UiSelect />
<UiModal />
<UiTable />
```

---

## 🎨 Customization

### Bootstrap theme override

Edit:

```
resources/scss/app.scss
```

```scss
$primary: #4f46e5;
$border-radius: 10px;
```

---

## 🧠 Pinia Store Example

```javascript
import { defineStore } from "pinia";

export const useUserStore = defineStore("user", {
  state: () => ({
    users: []
  }),

  actions: {
    setUsers(data) {
      this.users = data;
    }
  }
});
```

---

## 🏗 Build For Production

```bash
npm run build
```

Upload:

```
public/build
```

to your server.

---

## ✅ Best Practices

- Use props & emits
- Keep components small
- Use slots for flexibility
- Avoid duplicate UI
- Use composables
- Keep state inside Pinia

---

## 🚀 Roadmap

  * Dark mode
  - Dark mode
- [ ] Typescript support
- [ ] Form builder
- [ ] Datatable server-side API
- [ ] Package as npm library
- [ ] Storybook documentation

---

## 🤝


 i want to build a education flutter app with riverpod and repository pattern and with best standart structure.maintain full professional architech and lateer i will replace actual api only. Home page should have drawer and bottom navigation menu.in bottom navigation menu should contain stude&practice, Question Bank, Live Exam,Archive, Bookmark if click any item then open their actual screen. Drawer item should Profile, Performance Statistics,Bookmark, Wrong & Unanswered, Result, Settings,Our More Apps, Contact Us, Terms & Condition,Logout, you can use better word for this drawer item. and prepare individual screen for every drawer item and if click then should open. Design a nice and professional home page.

when click study & practice should display 1.Admission, 2.BCS & Others Job, 3.Bank
when clik Admission will show Subject Lists with box style  with nice design like Bangle 1st, Bangla 2nd, English, Economics, Analytics, Critical, Vash gian O bishesh dokkota, 
when click individual subject then show the Topic List like for bangla 1.Goddo , 2.Poddo, 3. Notok
after click each topic will display some mcq answer and question list more then 30 each page with pagination. each mcq qust should contain 4 options after each quest add a checkbox  to bookmark this  question .( later these all book mark quest will show under bookmark action from drawer.). After the options of each quest should 3 action . 1.answer 2.Explain, 3.favourite . use nice icon for all 3 option.
when click answer then make highlight the optino of this question . when click explain then show content as explanation of each quest. when click favourte then make this qustion as favourte. all favourite mcq quest ,option should list and drawer. Repeat this Admission system for Bcs and bank too.

Follow the system for Question Bank AND MAKE BOX DESIGN
Question Bank Option
    1.BCS
        Exam Year wise
          1st Bcs -> when click then show mcq as described before
          2nd Bcs -> when click then show mcq as described before
          ....

        Subject Wise
          Bangla -> when click then show mcq as described before
          Math-> when click then show mcq as described before
          English-> when click then show mcq as described before
          ...

    2.Bank
      Subject wise
        Bangla-> when click then show mcq as described before
        Math-> when click then show mcq as described before
        English-> when click then show mcq as described before

      Category Wise
        Sunali Bank-> when click then show mcq as described before
        Rupali Bank-> when click then show mcq as described before
        ..

    3.University
        DU
          Exam Year wise
            2005 -> when click then show mcq as described before
            2006 -> when click then show mcq as described before
          ....

          Subject Wise
            Bangla -> when click then show mcq as described before
            Math-> when click then show mcq as described before
            English-> when click then show mcq as described before
          ...

        CU
          Exam Year wise
            2005 -> when click then show mcq as described before
            2006 -> when click then show mcq as described before
          ....

          Subject Wise
            Bangla -> when click then show mcq as described before
            Math-> when click then show mcq as described before
            English-> when click then show mcq as described before
          ...


        RU
          Exam Year wise
            2005 -> when click then show mcq as described before
            2006 -> when click then show mcq as described before
          ....

          Subject Wise
            Bangla -> when click then show mcq as described before
            Math-> when click then show mcq as described before
            English-> when click then show mcq as described before
          ...


        JU
          Exam Year wise
            2005 -> when click then show mcq as described before
            2006 -> when click then show mcq as described before
          ....

          Subject Wise
            Bangla -> when click then show mcq as described before
            Math-> when click then show mcq as described before
            English-> when click then show mcq as described before
          ...


        JNU
          Exam Year wise
            2005 -> when click then show mcq as described before
            2006 -> when click then show mcq as described before
          ....

          Subject Wise
            Bangla -> when click then show mcq as described before
            Math-> when click then show mcq as described before
            English-> when click then show mcq as described before
          ...


live exam 
mcq question and option list with paginated  20 each page. user will check the answer finally will submit exam. should display exam time. and a progressbar for answered question. after submit the exam. will show a screen where display some info  result will public later. you will notify.
 from the like exam user also will be able any quest as bookmark. 


 ARCHIVE SCREEN
    ALL live exam mcq

  notice scren -- show sommy notice..

  now write a prompt to build a nice flutter application via claude and and essential feature and professional design