<script setup>
import SambutanSection from "./components/sambutan-section.vue";
import { getFullImagePath } from "@/utils/get-full-image-path";
import { onMounted, reactive, ref } from "vue";
import { fetchDataPosyanduMelati, fetchStrukturKepengurusan } from "./api/guest-tentang-page-api";
import { DEFAULT_POSYANDU_DATA } from "@/constants";
import Swal from "sweetalert2";
import { getErrorMessage } from "@/utils/get-error-message";

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
  <main class="d-flex flex-column gap-10 mb-10">
    <img style="
        width: 100vw;
        height: 550px;
        object-fit: cover;
        position: relative;
        top: 0px;
        filter: brightness(0.6);
      " :src="getFullImagePath(dataPosyanduMelati.gambar_gedung)" alt="" />
    <!-- Isi halaman utama Anda di sini -->
    <div style="position: absolute; top: 200px; width: 100vw">
      <Center>
        <h3 class="text-white text-h5">SELAMAT DATANG DI</h3>
        <h1 class="text-white text-h3">POSYANDU MELATI</h1>
      </Center>
    </div>

    <SambutanSection :foto-profile-ketua="getFullImagePath(dataPosyanduMelati.foto_profile_ketua)"
      :jabatan-ketua="dataPosyanduMelati.jabatan_ketua" :sambutan-ketua="dataPosyanduMelati.penyampaian_ketua"
      :nama-lengkap-ketua="dataPosyanduMelati.nama_lengkap_ketua" />


    <VRow v-for="(perlevel, index) in strukurKepengurusan" :key="index">
      <VCol v-for="(item) in perlevel" :key="item.email_admin" cols="6" md="3" lg="3" class="mx-auto mt-5">
        <VCard>
          <VCardItem>
            <img style="
              width: 150px;
              height: 150px;
              object-fit: cover;
              border-radius: 4px;
            " class="mx-auto d-block" :src="getFullImagePath(item.foto_profile)" :alt="item.nama_lengkap" />
            <div class="text-center mt-3">
              <h2 style="line-height: 1.5rem">{{ item.nama_lengkap }}</h2>
              <p>{{ item.nama_jabatan }}</p>
              <p>{{ item.email_admin }}</p>
            </div>
          </VCardItem>
        </VCard>
      </VCol>
      <div v-if="index != strukurKepengurusan.length - 1" style="width: 100%">
        <div style="
          height: 5px;
          width: 50%;
          background-color: rgba(
            var(--v-theme-on-background),
            var(--v-high-emphasis-opacity)
          );
          border-radius: 2px;
        " class="mx-auto"></div>
      </div>
    </VRow>

  </main>
</template>
