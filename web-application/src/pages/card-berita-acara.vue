<template>
  <VRow class="text-xs-left" style="margin-top: 150px">
    <VCol>
      <h2 class="caption">Berita <Font class="text-primary">Acara</Font>
      </h2>

      <p class="text-secondary">
        Informasi seputar BERITA & ACARA POSYANDU MELATI akan di tampilkan di
        sini
      </p>
    </VCol>
  </VRow>

  <VProgressCircular v-if="isLoading" indeterminate color="primary" class="mx-auto">
  </VProgressCircular>

  <VRow v-else class="mb-4">
    <VCol v-if="dataBerita.length == 0" cols="12">
      <Center>
        <h3 class="text-secondary">Belum ada berita..</h3>
      </Center>
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
import config from "@/@core/config";

export default {
  data() {
    return {
      isLoading: false,
      dataBerita: [],
      urlServer: config.urlServer,
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
        `${this.urlServer}/api/berita?start=${this.page}&length=${banyakDataTampil}`,
      );

      this.dataBerita = response.data.berita.map(item => {
        item.id_berita = btoa(item.id_berita);

        return item;
      });
      this.banyakPage = Math.ceil(response.data.jumlah_data / banyakDataTampil);
      this.isLoading = false;
    },

  },
};
</script>
