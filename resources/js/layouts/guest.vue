<script setup>
import GuestNavbar from './components/GuestNavbar.vue';
</script>

<template>
  <GuestNavbar>
    <RouterView />
  </GuestNavbar>
</template>

<style lang="scss">
// As we are using `layouts` plugin we need its styles to be imported
@use "@layouts/styles/default-layout";
</style>
