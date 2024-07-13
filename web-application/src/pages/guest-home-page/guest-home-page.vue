<script setup>
import Swal from "sweetalert2";
import GallerySection from "./components/sections/gallery-section.vue";
import HeroSection from "./components/sections/hero-section.vue";
import StatsSection from "./components/sections/stats-section.vue";
import SambutanSection from "./components/sections/sambutan-section.vue";
import { getFullImagePath } from "@/utils/get-full-image-path";
import { onMounted, reactive, ref } from "vue";
import { fetchDataPosyanduMelati, fetchJumlahBayi, fetchJumlahBerita, fetchJumlahEdukasi, fetchJumlahGambar } from "./api/guest-home-page-api";
import PreviewEdukasiSection from "./components/sections/preview-edukasi-section.vue";
import PreviewBeritaAcaraSection from "./components/sections/preview-berita-acara-section.vue";
import { getErrorMessage } from "@/utils/get-error-message";

const statsEdukasi = ref(0);
const statsBerita = ref(0);
const statsBayi = ref(0);
const statsGambar = ref(0);

const dataPosyanduMelati = reactive({
  nama_posyandu: '',
  kota: '',
  kecamatan: '',
  kelurahan: '',
  rt_rw: '',
  penyampaian_ketua: '',
  gambar_gedung: '',
  visi: '',
  misi: '',
  foto_profile_ketua: '',
  jabatan_ketua: "",
  nama_lengkap_ketua: "",
});

onMounted(async () => {
  try {
    statsBerita.value = await fetchJumlahBerita();
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
  <main class="d-flex flex-column gap-10">
    <HeroSection :gambar-gedung="getFullImagePath(dataPosyanduMelati.gambar_gedung)" />

    <StatsSection :stats-bayi="statsBayi" :stats-berita="statsBerita" :stats-edukasi="statsEdukasi"
      :stats-gambar="statsGambar" />

    <SambutanSection :foto-profile-ketua="getFullImagePath(dataPosyanduMelati.foto_profile_ketua)"
      :jabatan-ketua="dataPosyanduMelati.jabatan_ketua" :sambutan-ketua="dataPosyanduMelati.penyampaian_ketua"
      :nama-lengkap-ketua="dataPosyanduMelati.nama_lengkap_ketua" />

    <PreviewEdukasiSection />

    <PreviewBeritaAcaraSection />

    <GallerySection />
  </main>
</template>
