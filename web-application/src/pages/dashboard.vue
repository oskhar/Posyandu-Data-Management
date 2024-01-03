<script setup>
import AnalyticsCongratulations from "@/views/dashboard/AnalyticsCongratulations.vue";
import config from "@/@core/config.vue";
import { onMounted } from "vue";
import axios from "axios";

import chart from "@images/cards/chart-success.png";
import info from "@images/cards/chart-info.png";
import { ref } from "vue";

const urlServer = config.urlServer;
let data = ref([]);
let statEdukasi = ref(0);
let statBerita = ref(0);

// 👉 Images

const statGambar = ref(0);

const fetchBerita = async () => {
  const response = await axios.get(`${urlServer}/api/berita?start=0&length=0`);
  statBerita.value = response.data.jumlah_data;
};

const fetchEdukasi = async () => {
  const response = await axios.get(`${urlServer}/api/edukasi?start=0&length=0`);
  statEdukasi.value = response.data.jumlah_data;
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
  <VRow>
    <!-- 👉 Congratulations -->
    <VCol cols="12" md="12">
      <AnalyticsCongratulations />
    </VCol>

    <VCol cols="12" sm="12">
      <VRow>
        <!-- 👉 Profit -->
        <VCol cols="12" md="4">
          <CardStatisticsVertical href="/berita-acara" v-bind="{
            title: 'Jumlah Berita',
            image: chart,
            stats: statBerita,
          }" />
        </VCol>

        <!-- 👉 Sales -->
        <VCol cols="12" md="4">
          <CardStatisticsVertical href="/edukasi" v-bind="{
            title: 'Jumlah Edukasi',
            image: chart,
            stats: statEdukasi,
          }" />
        </VCol>
        <VCol cols="12" md="4">
          <CardStatisticsVertical href="/galeri" v-bind="{
            title: 'Jumlah Gambar',
            image: info,
            stats: statGambar,
          }" />
        </VCol>
      </VRow>
    </VCol>
  </VRow>
</template>
