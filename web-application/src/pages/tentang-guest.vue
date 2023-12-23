<template>
  <!-- Konten halaman -->
  <main>
    <img style="
        width: 100vw;
        height: 550px;
        object-fit: cover;
        position: relative;
        top: 0px;
        filter: brightness(0.8)" :src="imagePath + posyandu.gambar_gedung" alt="" />
    <!-- Isi halaman utama Anda di sini -->
    <div style="position: absolute;top: 200px;width: 100vw;">
      <center>
        <h3 class="text-white text-no-wrap text-h5">SELAMAT DATANG DI</h3>
        <h1 class="text-white text-no-wrap text-h3">POSYANDU MELATI</h1>
      </center>
    </div>
  </main>
  <VRow style="margin-top: 200px;">
    <VCol md="9" lg="9" sm="12" class="mx-auto">
      <VRow>
        <VCol md="8" sm="12">
          <VCardItem>
            <VCardTitle class="text-md-h5 text-primary">
              Sambutan Ketua Posyandu
            </VCardTitle>
          </VCardItem>

          <VCardText>
            <span>
              {{ posyandu.penyampaian_ketua }}

            </span>
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
      <VRow>
        <VCol cols="12">
          <VCard>
            <VCardItem>
              <VCardTitle class="text-md-h5 text-primary">
                VISI
              </VCardTitle>
              <p style="white-space: pre-line;">{{ posyandu.visi }}</p>
            </VCardItem>
          </VCard>
        </VCol>
        <VCol cols="12">
          <VCard>
            <VCardItem>
              <VCardTitle class="text-md-h5 text-primary">
                MISI
              </VCardTitle>
              <p style="white-space: pre-line;">{{ posyandu.misi }}</p>
            </VCardItem>
          </VCard>
        </VCol>
      </VRow>
    </VCol>
    <VCol cols="12" class="mx-auto my-5">
      <VCardItem>
        <h2 class="caption text-center">Struktur Keorganisasian <font class="text-primary">Posyanndu Melati</font>
        </h2>
        <p class="text-secondary text-center">
          Informasi seputar Struktur Organisasi yang terdapat pada posyandu melati.
        </p>
      </VCardItem>
    </VCol>
  </VRow>
  <section class="container">
    <VRow v-for="(perlevel, index) in strukurAdmin">
      <VCol v-for="item in perlevel" cols="6" md="3" lg="3" class="mx-auto mt-5">
        <VCard>
          <VCardItem>
            <img style="width: 200px; height: 200px; object-fit: cover; border-radius: 4px;" class="mx-auto d-block"
              :src="imagePath + item.foto_profile" alt="" />
            <div class="text-center mt-3">
              <h2 style="line-height: 1.5rem;">{{ item.nama_lengkap }}</h2>
              <p>{{ item.nama_jabatan }}</p>
              <p>{{ item.email_admin }}</p>
            </div>
          </VCardItem>
        </VCard>
      </VCol>
      <div style="width: 100%;" v-if="index != strukurAdmin.length - 1">
        <div
          style="height: 5px;width:50%;background-color: rgba(var(--v-theme-on-background), var(--v-high-emphasis-opacity));border-radius: 2px;"
          class="mx-auto"></div>
      </div>
    </VRow>
  </section>
  <div class="my-5"></div>
</template>

<script>
import axios from 'axios';
import config from '@/@core/config.vue';

export default {
  data() {
    return {
      dialog: false,
      profil: "Bapak / Ibu (Nama Lengkap)",
      strukurAdmin: [],
      imagePath: config.imagePath,
      posyandu: {},
    }
  },
  methods: {
    async fetchData() {

      const responsePosyandu = await axios.get(`${config.urlServer}/api/posyandu`);
      this.posyandu = responsePosyandu.data;

      const responseStruktur = await axios.get(`${config.urlServer}/api/struktur-admin`);
      this.strukurAdmin = responseStruktur.data;

    },

    save() {
      this.profil = profil;
    },
  },
  mounted() {
    this.fetchData();
  }
}
</script>