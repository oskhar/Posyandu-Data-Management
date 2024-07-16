<script>
import { api } from '@/lib/api';

export default {
  data() {
    return {
      dataEdukasi: {},
    }
  },
  mounted() {
    this.fetchData();
  },
  methods: {
    async fetchData() {

      // Membuat objek URLSearchParams dari query string
      const queryString = window.location.search;
      const queryParams = new URLSearchParams(queryString);

      // Mendapatkan nilai dari parameter tertentu
      if (queryParams.get("id_edukasi")) {
        const idEdukasi = atob(queryParams.get("id_edukasi"));
        const response = await api.get(`/edukasi?id_edukasi=${idEdukasi}`);

        this.dataEdukasi = response.data;
      } else {
        this.$router.push("/");
      }
    },
  },
}
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
