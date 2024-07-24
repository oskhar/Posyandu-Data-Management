<script setup>
import Swal from "sweetalert2";
import GallerySection from "./components/sections/gallery-section.vue";
import HeroSection from "./components/sections/hero-section.vue";
import LayananAndStats from "./components/sections/layanan-and-stats-section.vue";
import { getFullImagePath } from "@/utils/get-full-image-path";
import { onMounted, reactive, ref } from "vue";
import { fetchDataPosyanduMelati, fetchJumlahBayi, fetchJumlahEvents, fetchJumlahEdukasi, fetchJumlahGambar } from "./api/guest-home-page-api";
import PreviewEdukasiSection from "./components/sections/preview-edukasi-section.vue";
import PreviewEventsSection from "./components/sections/preview-events-section.vue";
import { getErrorMessage } from "@/utils/get-error-message";
import { DEFAULT_POSYANDU_DATA } from "@/constants";

const statsEdukasi = ref(0);
const statsEvents = ref(0);
const statsBayi = ref(0);
const statsGambar = ref(0);

const dataPosyanduMelati = reactive(DEFAULT_POSYANDU_DATA);

onMounted(async () => {
  try {
    statsEvents.value = await fetchJumlahEvents();
    statsEdukasi.value = await fetchJumlahEdukasi();
    statsGambar.value = await fetchJumlahGambar();
    statsBayi.value = await fetchJumlahBayi();

    const data = await fetchDataPosyanduMelati();

    Object.assign(dataPosyanduMelati, data);
  } catch (error) {
    await Swal.fire({
      icon: "error",
      text: getErrorMessage(error, "Terjadi kesalahan saat loading halaman utama!"),
      showCloseButton: true,
    });
  }
});
</script>

<template>
  <main class="d-flex flex-column gap-10" style="margin-top: -30px;">
    <HeroSection :gambar-gedung="getFullImagePath(dataPosyanduMelati.gambar_gedung)" />

    <LayananAndStats :stats-bayi="statsBayi" :stats-events="statsEvents" :stats-edukasi="statsEdukasi"
      :stats-gambar="statsGambar" />

    <PreviewEdukasiSection />

    <PreviewEventsSection />

    <GallerySection />
  </main>
</template>
