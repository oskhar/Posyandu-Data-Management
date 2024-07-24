<script setup>
import { api } from '@/lib/api';
import { getErrorMessage } from '@/utils/get-error-message';
import { errorToast } from '@/utils/toast';
import { ref } from 'vue';
import { useRoute, useRouter } from 'vue-router';

const router = useRouter();
const route = useRoute();
const dataEdukasi = ref({})

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
  }
}
onMounted(fetchData)
</script>

<template>
  <VRow style="margin-block: 70px;">
    <VCol cols="11" md="9" lg="9" class="mx-auto mt-5">
      <VCard>
        <VCardItem>
          <img class="mt-5" style="width: 100%; object-fit: cover" :src="imagePath + dataEdukasi.gambar" alt="" />
          <h2 class="text-h2 text-center">{{ dataEdukasi.judul }}</h2>
          <p class="text-center text-secondary">{{ dataEdukasi.tanggal }}</p>
          <p style="white-space: pre-line;">{{ dataEdukasi.materi }}</p>
          <p>Penulis: <span class="text-primary">{{ dataEdukasi.nama_lengkap }}</span></p>
          <RouterLink to="./">
            <div>
              <VIcon>bx-chevron-left</VIcon>
              Halaman Depan
            </div>
          </RouterLink>
        </VCardItem>
      </VCard>
    </VCol>
  </VRow>
</template>
