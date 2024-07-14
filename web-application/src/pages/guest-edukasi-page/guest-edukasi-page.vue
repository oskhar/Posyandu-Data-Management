<script setup>
import { onMounted, ref, watch } from "vue";
import { fetchDataEdukasi } from "./api/guest-edukasi-page-api";
import { getErrorMessage } from "@/utils/get-error-message";
import Swal from "sweetalert2";
import CardEdukasi from "@/components/cards/card-edukasi.vue";
import debounce from "just-debounce";

const isSearching = ref(true);
const isInitialLoading = ref(true);
const dataEdukasi = ref([]);
const page = ref(1);
const banyakPage = ref(0);
const searchQuery = ref("");

const searchEdukasi = async () => {
  try {
    isSearching.value = true;

    const { listDataEdukasi, pages } = await fetchDataEdukasi({
      page: page.value,
      search: searchQuery.value,
    });

    dataEdukasi.value = listDataEdukasi;
    banyakPage.value = pages;

  } catch (error) {
    await Swal.fire({
      icon: "error",
      text: getErrorMessage(error, "Terjadi kesalahan saat loading data edukasi!"),
      showCloseButton: true,
    });
  } finally {
    isSearching.value = false;
  }
}

const debouncedSearchEdukasi = debounce(searchEdukasi, 350)

const changeSearchPage = newPage => {
  page.value = newPage;
  searchEdukasi();
}

onMounted(async () => {
  await searchEdukasi()
  isInitialLoading.value = false
});

watch(searchQuery, debouncedSearchEdukasi)
watch(searchQuery, () => page.value = 1)
</script>

<template>
  <VRow tag="section" class="px-5 mb-4" style="margin-top: 90px;">
    <VCol cols="12" md="9" class="mx-auto">
      <h1 class="text-primary text-h5 font-weight-bold">Penyuluhan Edukasi</h1>
      <p class="text-secondary text-subtitle-1">
        Informasi seputar Edukasi Posyandu Melati akan di tampilkan di
        sini
      </p>

      <VTextField v-model="searchQuery" prepend-inner-icon="bx-search" label="Cari Postingan Edukasi" />

      <VRow v-if="isSearching && isInitialLoading" class="mt-5">
        <VCol v-for="i in 6" :key="i" cols="12" sm="6" lg="4">
          <VSkeletonLoader class="mx-auto border" type="image, article" />
        </VCol>
      </VRow>
      <VRow v-else-if="isSearching && !isInitialLoading" class="mt-5">
        <VCol cols="12" class="d-flex justify-center">
          <VProgressCircular indeterminate color="primary" size="50">
          </VProgressCircular>
        </VCol>
      </VRow>
      <VRow v-else class="mt-5">
        <VCol v-for="(data) in dataEdukasi" :key="data.id" cols="12" sm="6" md="4">
          <CardEdukasi :data-edukasi="data" />
        </VCol>
        <VCol v-if="dataEdukasi.length === 0" cols="12">
          <p class="mt-5 text-secondary text-center">Belum ada edukasi...</p>
        </VCol>
      </VRow>

      <VRow>
        <VCol cols="12">
          <VPagination v-model="page" :disabled="isSearching" size="x-large" :total-visible="5"
            :length="banyakPage || 1" @update:model-value="changeSearchPage" />
        </VCol>
      </VRow>
    </VCol>
  </VRow>
</template>
