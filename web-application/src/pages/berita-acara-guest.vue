<script>
import { api } from '@/lib/api';

export default {
  data() {
    return {
      dataBerita: {},
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
      if (queryParams.get("id_berita")) {
        const idBerita = atob(queryParams.get("id_berita"));
        const response = await api.get(`/berita?id_berita=${idBerita}`);

        this.dataBerita = response.data;
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
