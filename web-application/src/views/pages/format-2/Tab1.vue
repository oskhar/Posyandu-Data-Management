<template>
  <VRow>
    <VCol cols="12">
      <VCard>
        <VProgressCircular
          v-if="isLoading"
          indeterminate
          color="primary"
          class="mt-5 float-center"
          size="50"
        >
        </VProgressCircular>
        <VCardItem v-else style="min-height: 170px">
          <h2>Info Bayi</h2>
          <h3 class="text-secondary mt-5">{{ namaPosyandu }} - {{ kota }}</h3>
        </VCardItem>
        <VCardItem>
          <VSelect v-model="tahun" :items="listTahunLahir" />
        </VCardItem>
        <VCardItem>
          <VSelect v-model="bulan" :items="listBulanLahir" />
        </VCardItem>
      </VCard>
    </VCol>

    <VCol cols="12">
      <VCard>
        <!-- <VCardText> </VCardText> -->
        <VCardItem>
          <div class="d-flex justify-end">
            <VTextField v-model="dataSearch" append-inner-icon="bx-search">
            </VTextField>
            <VBtn class="ml-4" @click="exportExcel" prepend-icon="bx-download">
              Download
            </VBtn>
          </div>
          <VTable>
            <thead>
              <tr>
                <th>No</th>
                <th>Nama Anak</th>
                <th>Umur</th>
                <th>Kelamin</th>
                <th>Berat Badan</th>
                <th>Asi Eksklusif</th>
                <th>N/T/O/B & BGM</th>
                <th style="width: 220px">Aksi</th>
              </tr>
            </thead>

            <tbody>
              <VProgressCircular
                v-if="isLoading"
                indeterminate
                color="primary"
                class="mt-5 float-center"
                size="50"
              >
              </VProgressCircular>

              <tr
                v-else
                v-for="(item, index) in dataFormatBA"
                :key="item.dessert"
              >
                <td>
                  {{ (page - 1) * 20 + (index + 1) }}
                </td>
                <td>
                  {{ item.nama_bayi }}
                </td>
                <td class="text-center">{{ item.umur }} Bulan</td>
                <td class="text-center">
                  {{ item.jenis_kelamin }}
                </td>
                <td class="text-center">
                  {{ item.berat_badan }}
                </td>
                <td class="text-center">
                  {{ item.asi_eksklusif }}
                </td>
                <td class="text-center">
                  {{ item.ntob }}
                </td>
                <td class="text-center">
                  <VBtn
                    color="primary"
                    class="ml-2"
                    :href="`/data/format-2-edit?id_bayi=${item.id_bayi}`"
                  >
                    <v-icon>bx-edit</v-icon>
                  </VBtn>
                </td>
              </tr>
            </tbody>
          </VTable>
        </VCardItem>
      </VCard>
    </VCol>
  </VRow>
  <VRow>
    <VCol>
      <font
        >Jumlah data: <font class="text-primary">{{ jumlahData }}</font>
      </font>
      <v-pagination
        class="float-right"
        v-model="page"
        :length="banyakPage"
        :total-visible="4"
        @click="fetchData"
      ></v-pagination>
    </VCol>
  </VRow>
</template>

<script>
//import EditEdukasi from "./EditEdukasi.vue";
import axios from "axios";
import AnalyticsBarCharts from "@/views/dashboard/AnalyticsBarCharts.vue";
import config from "@/@core/config.vue";
import { ref } from "vue";
import Swal from "sweetalert2";
import VueApexCharts from "vue3-apexcharts";

export default {
  data() {
    const d = new Date();
    return {
      dataSearch: "",
      dialog: ref([]),
      urlServer: config.urlServer,
      page: 1,
      banyakPage: 5,
      dataFormatBA: [],
      judulFormatA: "",
      namaPosyandu: "",
      kota: "",
      jumlahData: 0,
      jumlahLahiran: "",
      jumlahMeninggal: "",
      tahun: d.getFullYear(),
      bulan: d.getMonth(),
      listTahunLahir: [d.getFullYear()],
      listBulanLahir: [
        { title: "Januari", value: 1 },
        { title: "Februari", value: 2 },
        { title: "Maret", value: 3 },
        { title: "April", value: 4 },
        { title: "Mei", value: 5 },
        { title: "Juni", value: 6 },
        { title: "Juli", value: 7 },
        { title: "Agustus", value: 8 },
        { title: "September", value: 9 },
        { title: "Oktober", value: 10 },
        { title: "November", value: 11 },
        { title: "Desember", value: 12 },
      ],
      isLoading: false,
      chartOptions: {},
    };
  },

  watch: {
    // Properti tahun akan dipantau
    tahun: function () {
      // Ketika tahun berubah, panggil fungsi fetchData
      this.page = 1;
      this.fetchData();
    },
    dataSearch: function () {
      this.fetchData();
    },
    bulan: function () {
      // Ketika tahun berubah, panggil fungsi fetchData
      this.page = 1;
      this.fetchData();
    },
  },
  methods: {
    async exportExcel() {
      const response = await axios({
        method: "get",
        url: `${this.urlServer}/api/export/format-a?tahun=${this.tahun}`,
        responseType: "blob",
        headers: {
          Authorization: localStorage.getItem("tokenAuth"),
        },
      });

      // Membuat objek Date yang merepresentasikan waktu saat ini
      const currentDate = new Date();

      // Mendapatkan tahun, bulan, tanggal, jam, menit, dan detik
      const year = currentDate.getFullYear();
      const month = currentDate.getMonth() + 1; // Perlu ditambah 1 karena indeks bulan dimulai dari 0
      const day = currentDate.getDate();
      const hours = currentDate.getHours();
      const minutes = currentDate.getMinutes();
      const seconds = currentDate.getSeconds();
      const currentDateTime = `_${year}-${month}-${day}_${hours}:${minutes}:${seconds}`;
      const namaFile = `Format-1${currentDateTime}.xlsx`;

      const url = window.URL.createObjectURL(new Blob([response.data]));
      const link = document.createElement("a");
      link.href = url;
      link.setAttribute("download", namaFile);
      document.body.appendChild(link);
      link.click();
    },
    async fetchData() {
      this.isLoading = true;
      const response = await axios.get(
        `${config.urlServer}/api/format-ba?length=20&start=${this.page}&bulan=${this.bulan}&tahun=${this.tahun}&search=${this.dataSearch}`,
        {
          headers: {
            Authorization: localStorage.getItem("tokenAuth"),
          },
        }
      );
      this.jumlahData = response.data.jumlah_data;
      this.dataFormatBA = response.data.format_ba;
      this.isLoading = false;
      return response;
    },
  },
  components: {
    AnalyticsBarCharts,
    VueApexCharts,
  },
  async mounted() {
    const response = await this.fetchData();
    this.banyakPage = Math.ceil(response.data.jumlah_data / 20);
    this.judulFormatA = response.data.judul_format;
    this.namaPosyandu = response.data.nama_posyandu;
    this.kota = response.data.kota;
    const response2 = await axios.get(`${config.urlServer}/api/listtahun`, {
      headers: {
        Authorization: localStorage.getItem("tokenAuth"),
      },
    });
    this.listTahunLahir = response2.data;
  },
};
</script>
