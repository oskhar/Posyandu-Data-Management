<script setup>
import { api } from '@/lib/api';
import { getErrorMessage } from '@/utils/get-error-message';
import { getFullImagePath } from '@/utils/get-full-image-path';
import { errorToast } from '@/utils/toast';
import { ref } from 'vue';
import { useRoute, useRouter } from 'vue-router';

const router = useRouter();
const route = useRoute();
const dataEdukasi = ref({});
const isLoading = ref(true);

async function fetchData() {
  try {
    const idEdukasi = route.params.id
    const response = await api.get(`/edukasi?id_edukasi=${idEdukasi}`);

    dataEdukasi.value = response.data;
  } catch (error) {
    errorToast({ text: getErrorMessage(error) })
    router.push('/edukasi')
  } finally {
    if (Object.keys(dataEdukasi.value).length === 0) {
      errorToast({ text: "Postingan edukasi gagal diambil!" })
      router.push('/edukasi')
    }

    isLoading.value = false;
  }
}
onMounted(fetchData)
</script>


<template>
  <VRow tag="section" class="px-5 mb-4">
    <VCol cols="12" md="9" class="mx-auto">
      <VCard>
        <VCardItem>
          <VBtn prepend-icon="bx-left-arrow-alt" variant="text" to="/layanan/resleting/tantangan" class="mb-4">
            Kembali
          </VBtn>

          <VRow class="mb-2" align="center">
            <VCol cols="12" md="9" lg="10">
              <VSkeletonLoader v-if="isLoading" type="heading" />
              <h1 v-else class="text-h5 text-sm-h4 text-primary font-weight-bold">
                {{ dataEdukasi.judul }}
              </h1>

              <VSkeletonLoader v-if="isLoading" type="subtitle" />
              <div v-else class="d-flex align-center gap-2 text-subtitle-1 mt-2">
                <VIcon icon="mdi-pencil" size="18" />
                <span>Ditulis oleh {{ dataEdukasi.nama_lengkap }}</span>
              </div>
              <VSkeletonLoader v-if="isLoading" type="subtitle" />
              <div v-else class="d-flex align-center gap-2 text-subtitle-1">
                <VIcon icon="mdi-calendar" size="18" />
                <span>{{ dataEdukasi.tanggal }}</span>
              </div>

            </VCol>

          </VRow>

          <VSkeletonLoader v-if="isLoading" type="image, paragraph" />

          <div>
            <div class="rounded-lg overflow-hidden">
              <VImg :src="getFullImagePath(dataEdukasi.gambar)" class="h-full" />
            </div>

            <div class="mt-6 edukasi-description" v-html="dataEdukasi.materi">
            </div>
          </div>
        </VCardItem>

      </VCard>
    </VCol>
  </VRow>
</template>

<style scoped>
.edukasi-description>* {
  margin-bottom: 20px;
}

.v-skeleton-loader {
  background-color: transparent;
}
</style>
