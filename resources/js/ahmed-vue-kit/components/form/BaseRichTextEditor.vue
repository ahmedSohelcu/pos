<!--
    ** TODO: letter add support for emoji
     ** TODO: letter add support for modules for file upload
-->

<script setup>
    import { ref, watch } from 'vue'
    import { QuillEditor } from '@vueup/vue-quill';
    import '@vueup/vue-quill/dist/vue-quill.snow.css';

    const props = defineProps({
        modelValue: {
            type: String,
            default: '' 
        },    
        contentType: { //must needed
            type: String,
            default: 'html' //Type: "delta" | "html" | "text" default html is import for textarea
        },
        placeholder: {
            type: String,
            default: 'Write something here...' 
        },    
        readOnly: {
            type: Boolean,
            default: false
        },
        theme: {
            type: String,
            default: 'snow' //Type: "snow" | "bubble" | ""
        },
        toolbar: {
            type: Array,
            default: 'full' //Type: 1. ['bold', 'italic', 'underline'] 2 minimal 3 full 4 ''                        
        },
    })

    const emit = defineEmits(['update:modelValue'])

    const content = ref(props.modelValue)

    // Sync parent → child
    watch(() => props.modelValue, val => {
        content.value = val
    })

    // Sync child → parent
    watch(content, val => {
        emit('update:modelValue', val)
    })
</script>

<template>
  <QuillEditor
    :content="modelValue" 
    :content-type="contentType"
    @update:content="$emit('update:modelValue', $event)"
    :readOnly="readOnly"
    :theme="theme"
    :toolbar="toolbar ? toolbar : ''" 
    :placeholder="placeholder"
  />
</template>

<!-- 
    How to use
    -------------

     <BaseRichTextEditor
        v-model="form.description"
        label="Quill Editor Description"
        :read-only="readOnly"
        :error="errors.description"
        :placeholder="'hello placeholder'"
    /> 


    ----------------------
    Other supported props
    ----------------------
    ** content-type: "delta" | "html" | "text" default html is needed for textarea
    ** reeadOnly Boolean to make editor read-only - default false
    ** theme: "snow" | "bubble" | ""
    ** toolbar =
                1. ['bold', 'italic', 'underline']
                2 minimal
                3 full
                4 ''

    ** toolbar: can pas an array of toolbar items
            toolbar:
                [
                    ['bold', 'italic', 'underline', 'strike'],
                    ['blockquote', 'code-block'],
                    [{ 'header': 1 }, { 'header': 2 }],
                    [{ 'list': 'ordered' }, { 'list': 'bullet' }],
                    [{ 'script': 'sub' }, { 'script': 'super' }],
                    [{ 'indent': '-1' }, { 'indent': '+1' }],
                    [{ 'direction': 'rtl' }],
                    [{ 'size': ['small', false, 'large', 'huge'] }],
                    [{ 'header': [1, 2, 3, 4, 5, 6, false] }],
                    [{ 'color': [] }, { 'background': [] }],
                    [{ 'font': [] }],
                    [{ 'align': [] }],
                    ['clean'],
                    ['link', 'image', 'video']
                ]

                <!--
                    Documentation for vue-quill textarea    
                    https://vueup.github.io/vue-quill/
                    

                    Example using quill-image-uploader 
                    https://vueup.github.io/vue-quill/guide/modules.html



                    Plugin for quill-emoji
                    ***https://vueup.github.io/vue-quill/guide/modules.html
                -->


        
