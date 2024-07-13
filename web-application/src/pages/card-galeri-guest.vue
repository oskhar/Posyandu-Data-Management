<template>
  <div class="text-center mt-5">
    <h1 class="mt-5">Galeri</h1>
    <p class="text-secondary">
      Kisah yang diabadikan dalam bentuk FOTO akan di tampilkan di
      sini
    </p>
  </div>

  <VProgressCircular v-if="isLoading" indeterminate color="primary" class="mx-auto">
  </VProgressCircular>

  <VRow v-else no-gutters>
    <VCol v-for="data in dataGambar" cols="12" md="3" sm="6">
      <VImg id="gambar" style="width: 100%; height: 200px" cover :src="data.gambar" alt="image"
        @click="lihatGambar(data.gambar, data.nama_lengkap)" />
      <!-- <h1>{{ data.id_gambar }}</h1> -->
    </VCol>
  </VRow>
  <VRow>
    <VCol>
      <div class="text-center my-3 float-right">
        <VPagination v-model="page" :length="banyakPage" :total-visible="5" @click="fetchData"></VPagination>
      </div>
    </VCol>
  </VRow>
</template>

<script>

//import EditEdukasi from "./EditEdukasi.vue";
import axios from "axios";
import config from "@/@core/config";
import Swal from "sweetalert2";

export default {
  data() {
    return {
      isLoading: false,
      dataGambar: [],
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

      const banyakDataTampil = 8;

      const response = await axios.get(
        `${config.urlServer}/api/gambar?start=${this.page}&length=${banyakDataTampil}`,
      );

      this.dataGambar = response.data.gambar.map(item => {
        item.gambar = config.imagePath + item.gambar;

        return item;
      });
      this.banyakPage = Math.ceil(response.data.jumlah_data / banyakDataTampil);
      this.isLoading = false;
    },

    lihatGambar(gambar, judul) {
      Swal.fire({
        imageUrl: gambar,
        html: judul,
        imageAlt: "Ini gambar",
      });
    },
  },
};
</script>

<style>
#gambar:hover {
  filter: brightness(0.7);
}
</style>
