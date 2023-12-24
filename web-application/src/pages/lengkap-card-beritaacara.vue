<template>
  <VCard>
    <VCardItem>
      <div class="container">
        <v-row class="text-xs-left" style="margin-top: 150px">
          <v-col>
            <h2 class="caption">Berita <font class="text-primary">Acara</font>
            </h2>

            <p class="text-secondary">
              Informasi seputar BERITA & ACARA POSYANDU MELATI akan di tampilkan di
              sini
            </p>
          </v-col>
        </v-row>

        <VRow>
          <!-- 👉 Popular Uses Of The Internet -->
          <VCol v-for="(data) in dataBerita" cols="6" sm="6" md="4">
            <RouterLink :to="`./berita-acara-guest?id_berita=${data.id_berita}`">
              <VCard>
                <VImg :src="data.gambar" cover style="height: 280px">
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
                </VCardText>
              </VCard>
            </RouterLink>
          </VCol>
        </VRow>
        <VRow>
          <VCol>
            <div class="text-center my-3 float-right" style="display: flex; justify-content: center">
              <v-pagination v-model="page" :length="banyakPage" :total-visible="5" @click="fetchData"></v-pagination>
            </div>
            <RouterLink to="./">
              <div>
                <v-icon>bx-chevron-left</v-icon>
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
import config from "@/@core/config.vue";

export default {
  data() {
    return {
      dataBerita: [],
      imagePath: config.imagePath,
      page: 1,
      banyakPage: 0,
    };
  },

  methods: {

    async fetchData() {
      const banyakDataTampil = 9;
      const response = await axios.get(
        `${config.urlServer}/api/berita?start=${this.page}&length=${banyakDataTampil}`
      );
      this.dataBerita = response.data.berita.map((item) => {
        item.id_berita = btoa(item.id_berita);
        item.gambar = this.imagePath + item.gambar;
        return item;
      });
      this.banyakPage = Math.ceil(response.data.jumlah_data / banyakDataTampil);
    },
  },

  mounted() {
    this.fetchData();
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
