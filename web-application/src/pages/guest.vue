<script setup>
import langit from "@images/pages/2.png";
import cardEdukasi from "./card-edukasi.vue";
import cardBeritaAcara from "./card-berita-acara.vue";
import cardGaleri from "./card-galeri-guest.vue";
import tentangGuest from "./tentang-guest.vue";
import footerGuest from "./footer-guest.vue";
import logo from "@images/logo.svg?raw";
import Sambutan from "./tentang-guest-atas.vue";

import iconTentangPosyandu from "@images/cards/icon-tentang-posyandu.png";
import iconEdukasi from "@images/cards/icon-edukasi-guest.png";
import iconBeritaAcara from "@images/cards/icon-berita-guest.png";
import { ref } from "vue";
import { onMounted } from "vue";
import axios from "axios";
import config from "@/@core/config.vue";

const urlServer = config.urlServer;
let statEdukasi = ref(0);
let statBerita = ref(0);

const statGambar = ref(0);

const fetchEdukasi = async () => {
  const response = await axios.get(`${urlServer}/api/edukasi?start=0&length=0`);
  statEdukasi.value = response.data.jumlah_data;
};

const fetchBerita = async () => {
  const response = await axios.get(`${urlServer}/api/berita?start=0&length=0`);
  statBerita.value = response.data.jumlah_data;
};

const fetchGambar = async () => {
  const response = await axios.get(`${urlServer}/api/gambar?start=0&length=0`);
  statGambar.value = response.data.jumlah_data;
};

onMounted(() => {
  fetchBerita();
  fetchEdukasi();
  fetchGambar();
});
</script>

<template>
  <RouterView />
  <img id="gambarPosyandu" style="
      width: 100%;
      height: 610px;
      object-fit: cover;
      position: absolute;
      margin: 0px auto;
    " :src="langit" alt="" />
  <div class="container-dua d-flex" style="justify-content: space-between; z-index: 1000; margin: 40px">
    <router-link to="/">
      <div class="d-flex text-primary" v-html="logo" />
    </router-link>
    <div>
      <ul style="
          color: aliceblue;
          display: flex;
          list-style: none;
          min-width: 5px;
          margin: 5px auto;
        ">
        <li class="listNavbar" style="margin: 10px">Home</li>
        <li class="listNavbar" style="margin: 10px">Edukasi</li>
        <li class="listNavbar" style="margin: 10px">Berita</li>
        <li class="listNavbar" style="margin: 10px">Tentang</li>
      </ul>
    </div>
    <router-link to="./login">
      <VBtn> Log in </VBtn>
    </router-link>
  </div>
  <div style="z-index: 100; margin-top: 80px">
    <center>
      <p class="text-white">Selamat Datang Di</p>
      <h1 class="text-white">POSYANDU MELATI</h1>
    </center>
  </div>
  <!-- CARD 3 -->
  <div class="container" style="margin-top: 350px">
    <VCol cols="12" sm="12">
      <VRow>
        <!-- 👉 Profit -->
        <VCol cols="12" md="4">
          <CardStatisticsVertical href="" v-bind="{
            title: 'Jumlah Berita',
            image: iconBeritaAcara,
            stats: statBerita,
          }" />
        </VCol>

        <!-- 👉 Sales -->
        <VCol cols="12" md="4">
          <CardStatisticsVertical href="" v-bind="{
            title: 'Jumlah Edukasi',
            image: iconEdukasi,
            stats: statEdukasi,
          }" />
        </VCol>
        <VCol cols="12" md="4">
          <CardStatisticsVertical href="" v-bind="{
            title: 'Jumlah Galeri',
            image: iconTentangPosyandu,
            stats: statGambar,
          }" />
        </VCol>
      </VRow>
    </VCol>
    <Sambutan />
    <cardEdukasi />
    <cardBeritaAcara />
    <tentangGuest />
    <cardGaleri />
  </div>
  <footerGuest />
</template>

<script></script>

<style scope>
.container {
  padding: 0 10px;
  margin: 30px;
}

.listNavbar:hover {
  cursor: pointer;
  color: #5468ff;
}

#gambarPosyandu {
  filter: brightness(0.8);
}

/* card 3 */
.kategori-card:hover {
  box-shadow: #5468ff;
}
</style>
