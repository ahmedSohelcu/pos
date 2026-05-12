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
