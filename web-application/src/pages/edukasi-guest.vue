<script setup>
import langit from "@images/pages/2.png";
import cardEdukasi from "./card-edukasi.vue";
</script>

<template>
  <div class="container">
    <img
      class="mt-5"
      style="width: 100%; height: 400px; object-fit: cover"
      :src="langit"
      alt=""
    />
    <Strong style="font-size: 40px">JUDUL</Strong>
    <p><sup>Tanggal</sup></p>
    <p>Paragraf</p>
    <p>Penulis</p>
    <router-link to="./">
      <VBtn block type="submit" class="mt-5"> Back </VBtn>
    </router-link>
  </div>

  <cardEdukasi />
</template>

<style scope>
.container {
  padding: 0 10px;
  margin: 30px;
}
</style>
