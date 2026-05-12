<script setup>
import { computed } from 'vue';

/*
|--------------------------------------------------------------------------
| Props
|--------------------------------------------------------------------------
*/
const props = defineProps({
  modelValue: {
    type: Number,
    default: 1,
  },
  lastPage: {
    type: Number,
    default: 1,
  },
  onEachSide: {
    type: Number,
    default: 2, // like Laravel default
  },
});

const emit = defineEmits(['update:modelValue']);

/*
|--------------------------------------------------------------------------
| Computed
|--------------------------------------------------------------------------
*/
const currentPage = computed(() => props.modelValue);

const elements = computed(() => {
  const total = props.lastPage;
  const current = currentPage.value;
  const side = props.onEachSide;

  if (total <= side * 2 + 6) {
    return Array.from({ length: total }, (_, i) => i + 1);
  }

  const pages = [];

  const start = Math.max(current - side, 1);
  const end = Math.min(current + side, total);

  // Always show first page
  pages.push(1);

  if (start > 2) {
    pages.push('...');
  }

  for (let i = start; i <= end; i++) {
    if (i !== 1 && i !== total) {
      pages.push(i);
    }
  }

  if (end < total - 1) {
    pages.push('...');
  }

  if (total !== 1) {
    pages.push(total);
  }

  return pages;
});

/*
|--------------------------------------------------------------------------
| Methods
|--------------------------------------------------------------------------
*/
const changePage = (page) => {
  if (page === '...') return;
  if (page < 1 || page > props.lastPage) return;
  if (page === currentPage.value) return;

  emit('update:modelValue', page);
};
</script>

<template>
  <div class="mt-3">
    <nav v-if="lastPage > 1">
      <ul class="pagination">
        <!-- Previous -->
        <li class="page-item" :class="{ disabled: currentPage === 1 }">
          <a
            class="page-link"
            href="#"
            @click.prevent="changePage(currentPage - 1)"
          >
            ‹ Previous
          </a>
        </li>

        <!-- Page Numbers -->
        <li
          v-for="(item, index) in elements"
          :key="index"
          class="page-item"
          :class="{
            active: item === currentPage,
            disabled: item === '...',
          }"
        >
          <a class="page-link" href="#" @click.prevent="changePage(item)">
            {{ item }}
          </a>
        </li>

        <!-- Next -->
        <li class="page-item" :class="{ disabled: currentPage === lastPage }">
          <a
            class="page-link"
            href="#"
            @click.prevent="changePage(currentPage + 1)"
          >
            Next ›
          </a>
        </li>
      </ul>
    </nav>
  </div>
</template>
