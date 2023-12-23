<template>
  <VCard>
    <VCardItem>
      <div class="container">
        <VRow class="text-xs-left" style="margin-top: 150px">
          <VCol>
            <h2 class="caption">Penyuluhan <font class="text-primary">Edukasi</font>
            </h2>
            <p class="text-secondary">
              Informasi seputar EDUKASI POSYANDU MELATI akan di tampilkan di
              sini
            </p>
          </VCol>
        </VRow>

        <V-row class="mt-5">
          <VCol v-for="(data) in dataEdukasi" cols="12" sm="6" md="4">
            <RouterLink to="./edukasi-guest">
              <VCard>
                <VImg :src="data.gambar" cover style="height: 200px">
                  <h2 v-if="data.gambar == urlServer + null" class="text-center text-secondary" style="margin-top: 25%">
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
        </V-row>

        <VRow>
          <VCol>
            <div class="text-center my-3 float-right">
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
import { ref } from "vue";
import Swal from "sweetalert2";

export default {
  data() {
    return {
      dataEdukasi: ref([]),
      urlServer: config.urlServer,
      refInput: ref(),
      page: 1,
      banyakPage: 0,
    };
  },

  methods: {

    async fetchData() {
      const banyakDataTampil = 9;
      const response = await axios.get(
        `${this.urlServer}/api/edukasi?start=${this.page}&length=${banyakDataTampil}`
      );
      this.dataEdukasi = response.data.edukasi.map((item) => {
        item.id_edukasi = ref(item.id_edukasi);
        item.judul = ref(item.judul);
        item.materi = ref(item.materi);
        item.gambar = ref(this.urlServer + item.gambar);
        item.refInput = ref();
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
