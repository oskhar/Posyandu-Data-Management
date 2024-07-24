<script setup>
import { api } from '@/lib/api';
import { getErrorMessage } from '@/utils/get-error-message';
import { errorToast } from '@/utils/toast';
import { ref } from 'vue';
import { useRoute, useRouter } from 'vue-router';

const route = useRoute();
const router = useRouter();
const dataEvent = ref({})


async function fetchData() {
  try {
    const idEvent = route.params.id
    const response = await api.get(`/berita?id_berita=${idEvent}`);

    dataEvent.value = response.data;
  } catch (error) {
    errorToast({ text: getErrorMessage(error) })
    router.push('/events')
  } finally {
    if (Object.keys(dataEvent.value).length === 0) {
      errorToast({ text: "Postingan event gagal diambil!" })
      router.push('/events')
    }
  }
}

onMounted(fetchData)
</script>

<template>
  <VRow>
    <VCol cols="11" md="9" lg="9" class="mx-auto mb-8">
      <VCard>
        <VCardItem>
          <img class="mt-5" style="width: 100%; object-fit: cover" :src="imagePath + dataEvent.gambar" alt="" />
          <h2 class="text-h2 text-center">{{ dataEvent.judul }}</h2>
          <p class="text-center text-secondary">{{ dataEvent.tanggal }}</p>
          <p style="white-space: pre-line;">{{ dataEvent.deskripsi }}</p>
          <p>Penulis Events: <span class="text-primary">{{ dataEvent.nama_lengkap }}</span></p>
          <p>
            <VIcon>bx-calendar</VIcon>
            Event dilaksanakan pada {{ dataEvent.tanggal_pelaksanaan }}
          </p>
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
