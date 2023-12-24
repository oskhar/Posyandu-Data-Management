<template>
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

  <VRow class="mb-4">
    <VCol v-if="dataBerita.length == 0" cols="12">
      <center>
        <h3 class="text-secondary">Belum ada berita..</h3>
      </center>
    </VCol>
    <!-- 👉 Popular Uses Of The Internet -->
    <VCol v-for="(data) in dataBerita" cols="12" md="4" lg="4">
      <RouterLink :to="`./berita-acara-guest?id_berita=${data.id_berita}`">
        <VCard>

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
            <p>
              Dilaksanakan {{ data.tanggal_pelaksanaan }}
            </p>
          </VCardText>
        </VCard>
      </RouterLink>
    </VCol>
  </VRow>
</template>

<script>
import axios from "axios";
import config from "@/@core/config.vue";

export default {
  data() {
    return {
      dataBerita: [],
      urlServer: config.urlServer,
      page: 1,
      banyakPage: 0,
    };
  },

  methods: {
    async fetchData() {
      const banyakDataTampil = 3;
      const response = await axios.get(
        `${this.urlServer}/api/berita?start=${this.page}&length=${banyakDataTampil}`
      );
      this.dataBerita = response.data.berita.map((item) => {
        item.id_berita = btoa(item.id_berita);
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
