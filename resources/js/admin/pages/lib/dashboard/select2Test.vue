<template>
    <div class="row">
        <div class="col">
            <select ref="selectRef" class="form-control">
                <option value="">Select User</option>
                <option value="1">Ahmed</option>
                <option value="2">Rayan</option>
            </select>
        </div>
        <div class="col">
            <select ref="selectRef" select2 class="form-control">
                <option value="">Select User</option>
                <option value="1">Ahmed</option>
                <option value="2">Rayan</option>
            </select>
        </div>

        <div class="col">
            <select ref="selectRef" select2 class="form-control" multiple>
                <option value="">Select User</option>
                <option value="1">Ahmed</option>
                <option value="2">Rayan</option>
            </select>
        </div>
    </div>
</template>

<script setup>

import { onMounted, ref, nextTick, onBeforeUnmount } from 'vue'

const selectRef = ref(null)

onMounted(async () => {
    await nextTick()
    $(selectRef.value).select2()
})

onBeforeUnmount(() => {
    if (selectRef.value) {
        $(selectRef.value).select2('destroy')
    }
})
</script>
