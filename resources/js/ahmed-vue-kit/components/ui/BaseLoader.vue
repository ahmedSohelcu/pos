<template>
    <td colspan="100%" class="text-center p-3">
    <!--begin::Spinner-->
        <div :class="`spinner-border text-${props.color}`" role="status">
            <span class="visually-hidden">Loading...</span>
        </div>        
    <!--end::Spinner-->
    </td>
</template>

<script setup>
    import { computed,} from 'vue'

    const props = defineProps({
        color: {
            type: String,
            default: 'success' //allow success, primary, secondary, warning, danger, light
        }
    })
</script>


