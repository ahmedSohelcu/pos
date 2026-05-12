#### Should create a documentation later using VuePress

## 💡 Reusable Component 💡
### 01. BaseInput 😎
```js
        <BaseInput
            label="Name"
            name="name"
            v-model="form.name"
            placeholder="Enter your name"
            :error="errors.username"
            @update:modelValue="val => name = val"
        />
```

### 0. BaseRadio 😎
```js

    <BaseRadio
        v-model="form.gender"
        name="gender"
        label="Gender"
        :options="genders"
        :error="errors.gender"
        :inline="true" // OR inline
        labelKey="name" //by default name
    />

    // Data
    const genders = [
        { id: 1, gender: 'Male'},
        { id: 2, gender: 'Female'},
        { id: 3, gender: 'Others'},
    ]
        
```

### 0. BaseCheckbox 😎
```json
    <BaseCheckbox
        v-model="form.fruits"
        name="fruits"
        label="fruits"
        :options="fruits"
        :error="errors.fruits"
        inline //or inline='true'
        labelKey="type" //defaut name
        />
        

        const fruits = [
            { id: 1, name: 'Banana'},
            { id: 2, name: 'Jack Fruits'},
            { id: 3, name: 'Pine Apple'},
        ]

        //labelKey="name" //according to array key name like name/type

        // to make selected for edit update
        //form.fruits: [1, 2,3], --to make selected

        //For Example
         const { form, errors, submit, loading } = useForm({
            username: '',
            email: '',
            phone: '',
            time: '',
            status_id: 1,
            states: [],
            category: [],
            gender: 1,
            fruits: [1, 2,3],
        })        
```

### 0. BaseTextarea 😎
```js
        
```
### 0. BaseRichTextEditor 😎
```js
        
```
### 0. BaseDatePicker 😎
```js
        
```
### 0. BaseSelect 😎
```js
        
```
### 0. BaseCard 😎
```js
        
```
### 0. BaseFilter 😎
```js
        
```
### 0. BaseForm 😎
```js
        
```
### 0. BaseLoader 😎
```js
        
```
### 0. BaseModal 😎
```js
        
```



💡 👉 📊 🧱 🛠 🎨 😎
