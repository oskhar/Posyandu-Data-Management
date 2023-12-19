<script setup>
import cardEdukasi from "./card-edukasi.vue";
import cardBeritaAcara from "./card-berita-acara.vue";
import cardGaleri from "./card-galeri-guest.vue";
import footerGuest from "./footer-guest.vue";

import Sambutan from "./tentang-guest-atas.vue";
import navbarGuest from "./navbar-guest.vue";

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
  const response = await axios.get(${urlServer}/api/edukasi?start=0&length=0);
  statEdukasi.value = response.data.jumlah_data;
};

const fetchBerita = async () => {
  const response = await axios.get(${urlServer}/api/berita?start=0&length=0);
  statBerita.value = response.data.jumlah_data;
};

const fetchGambar = async () => {
  const response = await axios.get(${urlServer}/api/gambar?start=0&length=0);
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

  <navbarGuest />

  <!-- CARD 3 -->
  <div class="container" style="margin-top: 200px">
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
      </VRow>
    </VCol>
    <Sambutan />
    <cardEdukasi />
    <cardBeritaAcara />
    <!-- <tentangGuest /> -->
    <cardGaleri />
  </div>
  <footerGuest />
</template>

<style scope>
.container {
  padding: 0 10px;
  margin: 30px;
}

.listNavbar:hover {
  cursor: pointer;
  color: #5468ff;
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