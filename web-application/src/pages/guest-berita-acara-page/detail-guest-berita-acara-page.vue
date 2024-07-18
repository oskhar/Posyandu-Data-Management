<script setup>
import { api } from '@/lib/api';
import { ref } from 'vue';
import { useRoute } from 'vue-router';

const route = useRoute();
const dataBerita = ref({})


async function fetchData() {
  const idBerita = route.params.id
  const response = await api.get(`/berita?id_berita=${idBerita}`);

  dataBerita.value = response.data;
}

onMounted(fetchData)
</script>

<template>
  <VRow style="margin-block: 70px;">
    <VCol cols="11" md="9" lg="9" class="mx-auto mt-5">
      <VCard>
        <VCardItem>
          <img class="mt-5" style="width: 100%; object-fit: cover" :src="imagePath + dataBerita.gambar" alt="" />
          <h2 class="text-h2 text-center">{{ dataBerita.judul }}</h2>
          <p class="text-center text-secondary">{{ dataBerita.tanggal }}</p>
          <p style="white-space: pre-line;">{{ dataBerita.deskripsi }}</p>
          <p>Penulis Berita: <span class="text-primary">{{ dataBerita.nama_lengkap }}</span></p>
          <p>
            <VIcon>bx-calendar</VIcon>
            Acara dilaksanakan pada {{ dataBerita.tanggal_pelaksanaan }}
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
