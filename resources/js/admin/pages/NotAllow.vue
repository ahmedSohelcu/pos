<template>
  <div class="container text-center py-5">
    <h1 class="display-5 fw-bold">Access Restricted</h1>
    <p class="lead mt-3">
      You do not have permission or your current subscription plan does not include this
      feature.
    </p>

    <router-link :to="{ name: 'dashboard' }" class="btn btn-primary mt-4">
      Go Back to Dashboard
    </router-link>
  </div>
</template>

<script setup>
// static page (no logic needed)
</script>
