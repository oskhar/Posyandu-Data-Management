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
  <img
    id="gambarPosyandu"
    style="
      width: 100%;
      height: 610px;
      object-fit: cover;
      position: absolute;
      margin: 0px auto;
    "
    :src="langit"
    alt=""
  />
  <div
    class="container-dua d-flex"
    style="justify-content: space-between; z-index: 1000; margin: 40px"
  >
    <router-link to="/">
      <div class="d-flex text-primary" v-html="logo"
    /></router-link>
    <router-link to="./login">
      <VBtn> Log in </VBtn>
    </router-link>
  </div>
  <div style="z-index: 100; margin-top: 80px">
    <center>
      <h4 style="color: white; font-size: 3vw">SELAMAT DATANG DI</h4>
      <strong style="color: white; font-size: 6vw">POSYANDU MELATI</strong>
    </center>
  </div>
  <!-- CARD 3 -->
  <div class="container" style="margin-top: 350px">
    <div class="card">
      <div class="text-center" style="margin-top: 200px">
        <strong style="font-size: 35px">KATEGORI - KATEGORI</strong>
      </div>
    </div>
    <VCol cols="12" sm="12">
      <VRow>
        <!-- 👉 Profit -->
        <VCol cols="12" md="4">
          <CardStatisticsVertical
            href=""
            v-bind="{
              title: 'Jumlah Berita',
              image: iconBeritaAcara,
              stats: statBerita,
            }"
          />
        </VCol>

        <!-- 👉 Sales -->
        <VCol cols="12" md="4">
          <CardStatisticsVertical
            href=""
            v-bind="{
              title: 'Jumlah Edukasi',
              image: iconEdukasi,
              stats: statEdukasi,
            }"
          />
        </VCol>
        <VCol cols="12" md="4">
          <CardStatisticsVertical
            href=""
            v-bind="{
              title: 'Jumlah Galeri',
              image: iconTentangPosyandu,
              stats: statGambar,
            }"
          />
        </VCol>
        <!-- 👉 Profit -->

        <!-- 👉 Sales -->
        <!-- <VCol cols="12" md="4">
          <CardStatisticsVertical
          v-bind="{
              title: 'Jumlah Gambar',
              image: info,
              stats: jumlahPengurus,
            }"
            />
          </VCol> -->
      </VRow>
    </VCol>
    <Sambutan />
    <cardEdukasi />
    <cardBeritaAcara />
    <cardGaleri />
    <tentangGuest />
  </div>
  <footerGuest />
</template>

<script></script>

<style scope>
.container {
  padding: 0 10px;
  margin: 30px;
}

#gambarPosyandu:hover {
  filter: brightness(0.7);
  text-shadow: 2px 2px 4px #000000;
}

/* card 3 */
.kategori-card:hover {
  box-shadow: #5468ff;
}
</style>
