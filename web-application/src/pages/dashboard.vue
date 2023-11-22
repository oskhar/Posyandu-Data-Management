<script setup>
import AnalyticsCongratulations from '@/views/dashboard/AnalyticsCongratulations.vue'


// 👉 Images
import chart from '@images/cards/chart-success.png'
import info from '@images/cards/chart-info.png'
import paypal from '@images/cards/paypal-error.png'
import wallet from '@images/cards/wallet-info.png'

const jumlahBerita = 120
const jumlahEdukasi = 90
const jumlahGambar = 72
const jumlahPengurus = 69


</script>

<template>
  <VRow>
    <!-- 👉 Congratulations -->
    <VCol
      cols="12"
      md="12"
    >
      <AnalyticsCongratulations />
    </VCol>

    <VCol
      cols="12"
      sm="12"
    >
      <VRow>
        <!-- 👉 Profit -->
        <VCol
          cols="12"
          md="3"
        >
          <CardStatisticsVertical
            v-bind="{
              title: 'Jumlah Berita',
              image: chart,
              stats: jumlahBerita,
            }"
          />
        </VCol>

        <!-- 👉 Sales -->
        <VCol
          cols="12"
          md="3"
        >
          <CardStatisticsVertical
            v-bind="{
              title: 'Jumlah Edukasi',
              image: info,
              stats: jumlahEdukasi,
            }"
          />
        </VCol>
        <!-- 👉 Profit -->
        <VCol
          cols="12"
          md="3"
        >
          <CardStatisticsVertical
            v-bind="{
              title: 'Jumlah Gambar',
              image: chart,
              stats: jumlahGambar,
            }"
          />
        </VCol>

        <!-- 👉 Sales -->
        <VCol
          cols="12"
          md="3"
        >
          <CardStatisticsVertical
            v-bind="{
              title: 'Jumlah Gambar',
              image: info,
              stats: jumlahPengurus,
            }"
          />
        </VCol>
      </VRow>
    </VCol>

    
  </VRow>
</template>
