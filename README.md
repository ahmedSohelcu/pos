🚀 Laravel Vue Reusable UI Components

A custom reusable Vue 3 component library built for Laravel projects to speed up development and maintain consistency across applications.

This package provides ready-to-use UI components like:

✅ Inputs
✅ Select / Dropdown
✅ Checkbox / Radio
✅ File Upload
✅ Table (search, filter, pagination)
✅ Modal
✅ Form validation
✅ Toast/Alert
✅ Layout utilities

Built using:

Laravel 10+

Vue 3 (Composition API)

Pinia (state management)

Bootstrap 5

Axios

📦 Features
✨ Form Components

Text Input

Number Input

Password Input

Email Input

Textarea

Select / Multi-select

Checkbox

Radio

Date & Datetime picker

File uploader

Validation ready

✨ UI Components

Modal

Confirm Dialog

Table (search + filter + pagination + sorting)

Loader / Spinner

Toast Notifications

Buttons

Badge

Card

Tabs

✨ Advanced

Reusable props

v-model support

Server-side pagination

API ready

Fully customizable

DRY architecture

Clean folder structure

📁 Project Structure
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
 │   ├── app.js
 │   └── bootstrap.js

⚙️ Installation
1️⃣ Clone project
git clone https://github.com/yourname/laravel-vue-components.git
cd laravel-vue-components

2️⃣ Install dependencies
composer install
npm install

3️⃣ Run project
php artisan serve
npm run dev

🔌 Setup Vue + Pinia
app.js
import { createApp } from "vue";
import { createPinia } from "pinia";
import App from "./App.vue";

const app = createApp(App);

app.use(createPinia());

app.mount("#app");

🧩 Usage Examples
✅ Input Component
UiInput.vue
<UiInput
    label="Name"
    v-model="form.name"
    placeholder="Enter name"
/>

Props
Prop	Type	Description
modelValue	String	v-model value
label	String	Label text
type	String	input type
placeholder	String	placeholder
✅ Select Component
<UiSelect
    v-model="form.role"
    :options="roles"
/>

roles = [
  { label: 'Admin', value: 1 },
  { label: 'User', value: 2 }
]

✅ Modal Component
<UiModal v-model="showModal" title="Create User">
    <p>Modal content here</p>
</UiModal>

✅ Table Component
<UiTable
    :columns="columns"
    :rows="users"
    searchable
    pagination
/>

columns = [
  { label: "Name", key: "name" },
  { label: "Email", key: "email" }
]

🎯 Global Registration (Optional)

Register all components globally:

import * as components from "./components/ui";

Object.entries(components).forEach(([name, component]) => {
    app.component(name, component);
});


Now you can use:

<UiInput />
<UiModal />
<UiTable />


without importing.

🎨 Customization
Change Bootstrap theme
resources/scss/app.scss


Override variables:

$primary: #4f46e5;
$border-radius: 8px;

🧠 State Management (Pinia)

Example:

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

📦 Build for Production
npm run build


Upload:

public/build


to server.

✅ Best Practices

✔ Use props + emits
✔ Keep components small
✔ Reusable logic with composables
✔ Avoid duplicate UI
✔ Use slots
✔ Follow atomic design

🤝 Contributing

Fork repo

Create branch

Commit changes

Submit PR

📌 Roadmap

 Dark mode

 Form builder

 Drag & drop upload

 Datatable server side

 Package as npm module

 Typescript support

🧑‍💻 Author

Ahmed Ullah
Laravel + Vue Fullstack Developer