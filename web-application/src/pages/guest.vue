<template>
  <!-- Konten halaman -->
  <main>
    <img style="
      width: 100vw;
      height: 550px;
      object-fit: cover;
      position: relative;
      top: 0px;
      filter: brightness(0.6)" :src="imagePath + posyandu.gambar_gedung" alt="" />
    <!-- Isi halaman utama Anda di sini -->
    <div style="position: absolute;top: 200px;width: 100vw;">
      <center>
        <h3 class="text-white text-h5">SELAMAT DATANG DI</h3>
        <h1 class="text-white text-h3">POSYANDU MELATI</h1>
      </center>
    </div>
  </main>
  <!-- CARD 3 -->
  <section class="mt-5">
    <VRow style="width: 96%;" class="mx-auto">
      <VCol cols="12" md="9" lg="9" class="mx-auto">
        <!-- 👉 Profit -->
        <VCard>
          <VCardItem>
            <VRow class="text-center">
              <VCol cols="6" md="3" lg="3">
                <h1 class="text-primary">
                  <VIcon>bx-news</VIcon>
                </h1>
                <h2 class="mb-1 text-h5 text-no-wrap">
                  Berita Acara
                </h2>
                <h5 class="text-h5 text-no-wrap mb-3">
                  {{ statBerita }}
                </h5>
              </VCol>

              <!-- 👉 Sales -->
              <VCol cols="6" md="3" lg="3">
                <h1 class="text-primary">
                  <VIcon>bx-book</VIcon>
                </h1>
                <h2 class="mb-1 text-h5 text-no-wrap">
                  Edukasi
                </h2>
                <h5 class="text-h5 text-no-wrap mb-3">
                  {{ statEdukasi }}
                </h5>
              </VCol>
              <VCol cols="6" md="3" lg="3">
                <h1 class="text-primary">
                  <VIcon>bx-image</VIcon>
                </h1>
                <h2 class="mb-1 text-h5 text-no-wrap">
                  Galeri
                </h2>
                <h5 class="text-h5 text-no-wrap mb-3">
                  {{ statGambar }}
                </h5>
              </VCol>
              <VCol cols="6" md="3" lg="3">
                <h1 class="text-primary">
                  <VIcon>bx-face</VIcon>
                </h1>
                <h2 class="mb-1 text-h5 text-no-wrap">
                  Bayi Terdata
                </h2>
                <h5 class="text-h5 text-no-wrap mb-3">
                  {{ statBayi }}
                </h5>
              </VCol>
            </VRow>
          </VCardItem>
        </VCard>
      </VCol>
      <VCol cols="11" md="9" lg="9" class="mx-auto">
        <VRow>
          <VCol md="8" cols="12">
            <VCardItem>
              <VCardTitle class="text-md-h5 text-primary">
                Sambutan Ketua Posyandu
              </VCardTitle>
            </VCardItem>

            <VCardText style="white-space: pre-line;">
              {{ posyandu.penyampaian_ketua }}
            </VCardText>
          </VCol>
          <VCol cols="12" md="4" sm="12">
            <VCard class="pt-5">
              <VCardItem>
                <img style="width: 250px; height: 250px; object-fit: cover; border-radius: 4px;" class="mx-auto d-block"
                  :src="imagePath + posyandu.foto_profile_ketua" alt="" />
                <div class="text-center mt-3">
                  <h2 style="line-height: 0.8rem;">{{ posyandu.nama_lengkap_ketua }}</h2>
                  <p>{{ posyandu.jabatan_ketua }}</p>
                </div>
              </VCardItem>
            </VCard>
          </VCol>
        </VRow>
      </VCol>
    </VRow>
    <VCard class="mt-5">
      <VCardItem>
        <VRow>
          <VCol cols="11" md="9" lg="9" class="mx-auto py-5">
            <cardEdukasi />
            <cardBeritaAcara />
          </VCol>
        </VRow>
      </VCardItem>
    </VCard>
    <VRow>
      <VCol cols="11" md="9" lg="9" class="mx-auto">
        <cardGaleri />
      </VCol>
    </VRow>
  </section>
</template>
<script>
import cardEdukasi from "./card-edukasi.vue";
import cardBeritaAcara from "./card-berita-acara.vue";
import cardGaleri from "./card-galeri-guest.vue";
import langit from "@images/pages/2.png";

import axios from "axios";
import config from "@/@core/config.vue";
export default {
  components: {
    cardEdukasi,
    cardBeritaAcara,
    cardGaleri,
  },
  data() {
    return {
      urlServer: config.urlServer,
      statEdukasi: 0,
      statBerita: 0,
      statBayi: 0,
      statGambar: 0,
      imagePath: config.imagePath,
      posyandu: {},
    };
  },
  methods: {
    async fetchEdukasi() {
      const response = await axios.get(`${this.urlServer}/api/edukasi?start=0&length=0`);
      this.statEdukasi = response.data.jumlah_data;
    },

    async fetchBerita() {
      const response = await axios.get(`${this.urlServer}/api/berita?start=0&length=0`);
      this.statBerita = response.data.jumlah_data;
    },

    async fetchGambar() {
      const response = await axios.get(`${this.urlServer}/api/gambar?start=0&length=0`);
      this.statGambar = response.data.jumlah_data;
    },

    async fetchBayi() {
      const response = await axios.get(`${this.urlServer}/api/jumlah-bayi`);
      this.statBayi = response.data;
    },

    async fetchPosyandu() {
      const responsePosyandu = await axios.get(`${config.urlServer}/api/posyandu`);
      this.posyandu = responsePosyandu.data;
    },

  },
  mounted() {
    this.fetchBerita();
    this.fetchEdukasi();
    this.fetchGambar();
    this.fetchBayi();
    this.fetchPosyandu();
  }
};
</script>

