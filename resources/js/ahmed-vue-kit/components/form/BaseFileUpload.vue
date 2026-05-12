<script setup>
import { ref, watch } from 'vue'
import axios from 'axios'

const props = defineProps({
    modelValue: [Array, Object, null],
    label: String,
    required: Boolean,
    existingFiles: {
        type: Array,
        default: () => []
    },
    multiple: {
        type: Boolean,
        default: false
    },
    deleteUrl: String,
    maxSize: {
        type: Number,
        default: 2048 // KB
    }
})

const emit = defineEmits(['update:modelValue'])

const inputRef = ref(null)
const newFiles = ref([])
const previews = ref([])
const existing = ref([...props.existingFiles])
const errors = ref([])

watch(newFiles, () => {
    emit(
        'update:modelValue',
        props.multiple ? newFiles.value : newFiles.value[0] || null
    )
})

const triggerFile = () => {
    inputRef.value.click()
}

const handleFileChange = (event) => {
    errors.value = []

    let files = []

    if (event.dataTransfer) {
        files = Array.from(event.dataTransfer.files)
    } else {
        files = Array.from(event.target.files)
    }

    if (!props.multiple) {
        newFiles.value = []
        previews.value = []
    }

    files.forEach(file => {

        if (file.size / 1024 > props.maxSize) {
            errors.value.push(`${file.name} exceeds ${props.maxSize}KB`)
            return
        }

        newFiles.value.push(file)
        previews.value.push(URL.createObjectURL(file))
    })
}

const removeNew = (index) => {
    newFiles.value.splice(index, 1)
    previews.value.splice(index, 1)
}

const removeExisting = async (file, index) => {
    if (!props.deleteUrl) return

    try {
        await axios.delete(props.deleteUrl, {
            data: { id: file.id }
        })
        existing.value.splice(index, 1)
    } catch (error) {
        alert('Failed to delete file from server')
    }
}
</script>

<template>
<div class="upload-container">

    <!-- Label -->
    <label v-if="label" class="upload-label">
        {{ label }}
        <span v-if="required" class="required">*</span>
    </label>


    <!-- Drop Zone -->
    <div
        class="drop-zone"
        @click="triggerFile"
        @dragover.prevent
        @drop.prevent="handleFileChange"
    >
        <input
            ref="inputRef"
            type="file"
            class="hidden-input"
            :multiple="multiple"
            @change="handleFileChange"
        />

        <div class="drop-content">
            <div class="upload-icon">📤</div>
            <p class="upload-text">
                Click to upload or drag & drop
            </p>
            <small class="upload-subtext">
                Max size: {{ maxSize }} KB
            </small>
        </div>
    </div>

    <!-- Errors -->
    <div v-if="errors.length" class="error-box">
        <div v-for="err in errors" :key="err">{{ err }}</div>
    </div>

    <!-- Preview -->
    <div
        v-if="existing.length || previews.length"
        class="preview-grid"
    >


        <!-- Existing Files -->
        <div
            v-for="(file,index) in existing"
            :key="'old-'+file.id"
            class="preview-card"
        >
            <img :src="file.url" />

            <div class="overlay">
                <button @click="removeExisting(file,index)">
                    Delete
                </button>
            </div>
        </div>

        <!-- New Files -->
        <div
            v-for="(src,index) in previews"
            :key="'new-'+index"
            class="preview-card"
        >
            <img :src="src" />

            <div class="overlay">
                <button @click="removeNew(index)">
                    Remove
                </button>
            </div>
        </div>

    </div>

</div>
</template>

<style scoped>

.upload-container {
    margin-bottom: 25px;
}

.upload-label {
    display: block;
    font-weight: 600;
    margin-bottom: 6px;
}

.required {
    color: red;
    margin-left: 4px;
}

.drop-zone {
    border: 2px dashed #d1d5db;
    border-radius: 12px;
    padding: 35px;
    text-align: center;
    cursor: pointer;
    transition: 0.3s ease;
    background: #fafafa;
}

.drop-zone:hover {
    border-color: #4f46e5;
    background: #f3f4ff;
}

.hidden-input {
    display: none;
}

.upload-icon {
    font-size: 30px;
    margin-bottom: 10px;
    color: #4f46e5;
}

.upload-text {
    margin: 0;
    font-weight: 500;
}

.upload-subtext {
    color: #6b7280;
}

.preview-grid {
    margin-top: 20px;
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(130px, 1fr));
    gap: 15px;
}

.preview-card {
    position: relative;
    border-radius: 10px;
    overflow: hidden;
    box-shadow: 0 5px 15px rgba(0,0,0,0.08);
}

.preview-card img {
    width: 100%;
    height: 130px;
    object-fit: cover;
}

.overlay {
    position: absolute;
    inset: 0;
    background: rgba(0,0,0,0.6);
    display: flex;
    align-items: center;
    justify-content: center;
    opacity: 0;
    transition: 0.3s;
}

.preview-card:hover .overlay {
    opacity: 1;
}

.overlay button {
    background: #ef4444;
    color: white;
    border: none;
    padding: 6px 12px;
    border-radius: 6px;
    cursor: pointer;
}

.error-box {
    margin-top: 12px;
    color: #ef4444;
}

</style>


<!-- Example how to use 
<BaseFileUpload
    v-model="form.images"
    label="Product Images"
    :required="true"
    :multiple="true"
    :existing-files="existingImages"
    delete-url="/product/image/delete"
    :max-size="5000"
/>

    const form = reactive(
        {
            images: []
        }
    )
  
  // Existing Data
  const existingImages = [
    {id: 1, url: 'https://placehold.co/600x400/png'},
    {id: 2, url: 'https://placehold.co/600x400/png'}
  ]
-->