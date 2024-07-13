<template>
  <VRow class="text-xs-left" style="margin-top: 150px">
    <VCol>
      <h2 class="caption">Penyuluhan <Font class="text-primary">Edukasi</Font>
      </h2>
      <p class="text-secondary">
        Informasi seputar EDUKASI POSYANDU MELATI akan di tampilkan di
        sini
      </p>
    </VCol>
  </VRow>

  <VProgressCircular v-if="isLoading" indeterminate color="primary" class="mx-auto">
  </VProgressCircular>

  <VRow v-else class="mt-5">
    <VCol v-if="dataEdukasi.length == 0" cols="12">
      <Center>
        <h3 class="text-secondary">Belum ada edukasi..</h3>
      </Center>
    </VCol>
    <VCol v-for="(data) in dataEdukasi" v-else cols="12" md="4" lg="4">
      <RouterLink :to="`./edukasi-guest?id_edukasi=${data.id_edukasi}`">
        <VCard>
          <VImg :src="data.gambar" cover style="height: 200px">
            <h2 v-if="data.gambar == imagePath + null" class="text-center text-secondary" style="margin-top: 25%">
              Tidak Ada Foto
            </h2>
          </VImg>

          <VCardItem>
            <VCardTitle>{{ data.judul }}</VCardTitle>
            <sup>
              <VIcon class="text-primary">bx-calendar</VIcon> {{ data.tanggal }}
            </sup>
          </VCardItem>

          <VCardText>
            <p v-if="data.overview" class="mb-4">
              {{ data.overview }}
            </p>
            <p v-else class="text-secodary">
              ..
            </p>
            <p>penulis: {{ data.nama_lengkap }}</p>
          </VCardText>
        </VCard>
      </RouterLink>
    </VCol>
  </VRow>
</template>

<script>
//import EditEdukasi from "./EditEdukasi.vue";
import axios from "axios";
import config from "@/@core/config";

export default {
  data() {
    return {
      isLoading: false,
      dataEdukasi: [],
      urlServer: config.urlServer,
      imagePath: config.imagePath,
      page: 1,
      banyakPage: 0,
    };
  },

  mounted() {
    this.fetchData();
  },

  methods: {

    async fetchData() {
      this.isLoading = true;

      const banyakDataTampil = 3;

      const response = await axios.get(
        `${this.urlServer}/api/edukasi?start=${this.page}&length=${banyakDataTampil}`,
      );

      this.dataEdukasi = response.data.edukasi.map(item => {
        item.id_edukasi = btoa(item.id_edukasi);
        item.gambar = this.imagePath + item.gambar;

        return item;
      });
      this.banyakPage = Math.ceil(response.data.jumlah_data / banyakDataTampil);
      this.isLoading = false;
    },

  },
};
</script>

<style scope>
.card-tiga {
  display: flex;
  justify-content: space-between;
  margin-top: 50px;
}
</style>
