<template>
  <VCard>
    <VCardItem>
      <div class="container">
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

        <VRow class="mt-5">
          <VCol v-for="(data) in dataEdukasi" cols="12" sm="6" md="4">
            <RouterLink :to="`./edukasi-guest?id_edukasi=${data.id_edukasi}`">
              <VCard>
                <VImg :src="data.gambar" cover style="height: 200px">
                  <h2 v-if="data.gambar == imagePath + null" class="text-center text-secondary" style="margin-top: 25%">
                    Tidak Ada Foto
                  </h2>
                </VImg>

                <VCardItem>
                  <VCardTitle>{{ data.judul }}</VCardTitle>
                  <sup>{{ data.tanggal }}</sup>
                </VCardItem>

                <VCardText>
                  <p class="mb-4">
                    {{ data.overview }}
                  </p>
                  <p>penulis: {{ data.nama_lengkap }}</p>
                </VCardText>
              </VCard>
            </RouterLink>
          </VCol>
        </VRow>

        <VRow>
          <VCol>
            <div class="text-center my-3 float-right">
              <VPagination v-model="page" :length="banyakPage" :total-visible="5" @click="fetchData"></VPagination>
            </div>
            <RouterLink to="./">
              <div>
                <VIcon>bx-chevron-left</VIcon>
                Kembali
              </div>
            </RouterLink>
          </VCol>
        </VRow>
      </div>
    </VCardItem>
  </VCard>
</template>

<script>
import axios from "axios";
import config from "@/@core/config";

export default {
  data() {
    return {
      dataEdukasi: [],
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
      const banyakDataTampil = 9;

      const response = await axios.get(
        `${config.urlServer}/api/edukasi?start=${this.page}&length=${banyakDataTampil}`,
      );

      this.dataEdukasi = response.data.edukasi.map(item => {
        item.id_edukasi = btoa(item.id_edukasi);
        item.gambar = this.imagePath + item.gambar;

        return item;
      });
      this.banyakPage = Math.ceil(response.data.jumlah_data / banyakDataTampil);
    },

  },
};
</script>

<style scope>
.container {
  padding: 0 10px;
  margin: 30px;
}

.card-tiga {
  display: flex;
  justify-content: space-between;
  margin-top: 50px;
}
</style>
