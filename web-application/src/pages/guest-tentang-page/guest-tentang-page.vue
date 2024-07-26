<script setup>
import SambutanSection from "./components/sambutan-section.vue";
import { getFullImagePath } from "@/utils/get-full-image-path";
import { onMounted, reactive, ref } from "vue";
import { fetchDataPosyanduMelati, fetchStrukturKepengurusan } from "./api/guest-tentang-page-api";
import { DEFAULT_POSYANDU_DATA } from "@/constants";
import Swal from "sweetalert2";
import { getErrorMessage } from "@/utils/get-error-message";
import VisiMisiSection from "./components/visi-misi-section.vue";
import StrukturOrganisasi from "./components/struktur-organisasi.vue"

const strukurKepengurusan = ref([]);
const dataPosyanduMelati = reactive(DEFAULT_POSYANDU_DATA);

onMounted(async () => {
  try {
    strukurKepengurusan.value = await fetchStrukturKepengurusan();

    const posyandu = await fetchDataPosyanduMelati();


    Object.assign(dataPosyanduMelati, posyandu);
  } catch (error) {
    await Swal.fire({
      icon: "error",
      text: getErrorMessage(error, "Terjadi kesalahan saat loading halaman tentang!"),
      showCloseButton: true,
    });
  }
});
</script>


<template>
  <!-- Konten halaman -->
  <main class="d-flex flex-column gap-10 mb-10" style="margin-top: -30px;">
    <div style="height:500px" class="position-relative d-flex align-center justify-space-between">
      <VImg cover min-width="100%" class="position-absolute" height="500"
        style="object-position:top; filter: brightness(0.6);" :src="getFullImagePath(dataPosyanduMelati.gambar_gedung)"
        alt="" />
      <div class="text-center position-relative w-100" style="z-index: 10">
        <h3 class="text-white text-h5">Tentang Kami</h3>
        <h1 class="text-white text-h3">Posyandu Melati RW 9</h1>
      </div>
    </div>

    <SambutanSection :foto-profile-ketua="getFullImagePath(dataPosyanduMelati.foto_profile_ketua)"
      :jabatan-ketua="dataPosyanduMelati.jabatan_ketua" :sambutan-ketua="dataPosyanduMelati.penyampaian_ketua"
      :nama-lengkap-ketua="dataPosyanduMelati.nama_lengkap_ketua" />

    <VisiMisiSection :visi="dataPosyanduMelati.visi" :misi="dataPosyanduMelati.misi" />

    <StrukturOrganisasi :foto-struktur-organisasi="getFullImagePath(dataPosyanduMelati.gambar_struktur_organisasi)" />

  </main>
</template>
