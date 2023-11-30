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

const jumlahGambar = 72;

const fetchBerita = async () => {
  const response1 = await axios.get(`${urlServer}/api/berita`);
  data = response1.data;
  statBerita.value += data.length;
  console.log(statBerita);
};

const fetchEdukasi = async () => {
  const response2 = await axios.get(`${urlServer}/api/edukasi`);
  data = response2.data;
  statEdukasi.value += data.length;
  console.log(statEdukasi);
};

onMounted(() => {
  fetchEdukasi();
  fetchBerita();
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
          <CardStatisticsVertical
            v-bind="{
              title: 'Jumlah Berita',
              image: chart,
              stats: statBerita,
            }"
          />
        </VCol>

        <!-- 👉 Sales -->
        <VCol cols="12" md="4">
          <CardStatisticsVertical
            v-bind="{
              title: 'Jumlah Edukasi',
              image: chart,
              stats: statEdukasi,
            }"
          />
        </VCol>
        <VCol cols="12" md="4">
          <CardStatisticsVertical
            v-bind="{
              title: 'Jumlah Gambar',
              image: info,
              stats: jumlahGambar,
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
  </VRow>
</template>
