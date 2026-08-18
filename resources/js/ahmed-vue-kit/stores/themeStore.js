import { ref } from 'vue';
import { defineStore } from 'pinia';

const STORAGE_KEY = 'app-theme';

function getInitialTheme() {
  const saved = localStorage.getItem(STORAGE_KEY);

  if (saved === 'light' || saved === 'dark') {
    return saved;
  }

  return window.matchMedia?.('(prefers-color-scheme: dark)').matches ? 'dark' : 'light';
}

export const useThemeStore = defineStore('theme', () => {
  const theme = ref(getInitialTheme());

  function apply() {
    document.documentElement.setAttribute('data-bs-theme', theme.value);
    localStorage.setItem(STORAGE_KEY, theme.value);
  }

  function toggle() {
    theme.value = theme.value === 'dark' ? 'light' : 'dark';
    apply();
  }

  function setTheme(value) {
    theme.value = value === 'dark' ? 'dark' : 'light';
    apply();
  }

  apply();

  return { theme, apply, toggle, setTheme };
});