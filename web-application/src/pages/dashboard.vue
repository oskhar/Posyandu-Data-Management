<script setup>
import AnalyticsCongratulations from "@/views/dashboard/AnalyticsCongratulations.vue";
import config from "@/@core/config";
import { onMounted, ref } from "vue";
import axios from "axios";

import chart from "@images/cards/chart-success.png";
import info from "@images/cards/chart-info.png";

const urlServer = config.urlServer;
let data = ref([]);
let statEdukasi = ref(0);
let statEvents = ref(0);
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
