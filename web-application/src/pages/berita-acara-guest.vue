<script setup>
import langit from "@images/pages/2.png";
import cardBeritaAcara from "./card-berita-acara.vue";
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
    <br />
    <RouterLink to="./">
      <div>
        <v-icon>bx-chevron-left</v-icon>
        Halaman Depan
      </div>
    </RouterLink>
  </div>

  <cardBeritaAcara />
</template>

<style scope>
.container {
  padding: 0 10px;
  margin: 30px;
}
</style>
