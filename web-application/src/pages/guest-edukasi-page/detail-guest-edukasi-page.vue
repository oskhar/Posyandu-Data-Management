<script setup>
import { api } from '@/lib/api';
import { ref } from 'vue';
import { useRoute } from 'vue-router';

const route = useRoute();
const dataEdukasi = ref({})


async function fetchData() {
  const idEdukasi = route.params.id
  const response = await api.get(`/edukasi?id_edukasi=${idEdukasi}`);

  dataEdukasi.value = response.data;
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
