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
let statGambar = ref(0);
</script>

<template>
  <VRow>
    <!-- 👉 Congratulations -->
    <VCol cols="12" md="12">
      <AnalyticsCongratulations />
    </VCol>
  </VRow>
</template>
