<script setup>
import langit from "@images/pages/2.png";
import cardEdukasi from "./card-edukasi.vue";
</script>

<template>
  <img class="mt-5" style="width: 100%; height: 400px; object-fit: cover" :src="langit" alt="" />
  <h1>{{ }}</h1>
  <sup>{{ }}</sup>
  <p>{{}}</p>
  <br />
  <RouterLink to="./">
    <div>
      <v-icon>bx-chevron-left</v-icon>
      Halaman Depan
    </div>
  </RouterLink>

  <cardEdukasi />
</template>