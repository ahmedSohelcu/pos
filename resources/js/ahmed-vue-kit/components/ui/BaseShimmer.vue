<script setup>
    const props = defineProps({
        width: { type: String, default: '100%' },
        height: { type: String, default: '16px' },
        rounded: { type: Boolean, default: true },
        className: { type: String, default: '' }
    })
</script>

<template>
    <div
        :class="['shimmer', rounded ? 'shimmer-rounded' : '', className]"
        :style="{ width, height }"
    ></div>
</template>

<style scoped>
.shimmer {
    position: relative;
    overflow: hidden;
    background-color: #e0e0e0;
}

.shimmer::before {
    content: '';
    position: absolute;
    top: 0;
    left: -150%;
    height: 100%;
    width: 150%;
    background: linear-gradient(
        90deg,
        rgba(255,255,255,0) 0%,
        rgba(255,255,255,0.4) 50%,
        rgba(255,255,255,0) 100%
    );
    animation: shimmer 1.2s infinite;
}

.shimmer-rounded {
    border-radius: 8px;
}

@keyframes shimmer {
    100% {
        transform: translateX(100%);
    }
}
</style>

<!--
Example of how to use this component
<div v-if="loading">
      <BaseShimmer width="100%" height="200px" rounded />
      <BaseShimmer width="60%" height="20px" className="mt-3" />
      <BaseShimmer width="80%" height="14px" className="mt-2" />
      <BaseShimmer width="90%" height="14px" className="mt-2" />
    </div>

    <div v-else>
      <div class="real-content">
        <img :src="post.image" class="w-full h-52 object-cover rounded" />
        <h3 class="font-bold text-lg mt-3">{{ post.title }}</h3>
        <p class="text-gray-700 mt-2">{{ post.body }}</p>
      </div>
    </div>

    


<script setup>
    import { ref, onMounted } from 'vue'
    import BaseShimmer from '@/components/BaseShimmer.vue'

    const loading = ref(true)
    const post = ref({ title: '', body: '', image: '' })

    onMounted(() => {
        setTimeout(() => {
            post.value = {
            title: 'Hello World',
            body: 'This is the content loaded from backend',
            image: 'https://picsum.photos/600/300'
            }
            loading.value = false
        }, 2000)
    })
</script>
-->