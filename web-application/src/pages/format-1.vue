<template>
  <VRow>
    <VCol cols="12" md="8" sm="12">
      <VCard>
        <VProgressCircular v-if="isLoading" indeterminate color="primary" class="mt-5 float-center" size="50">
        </VProgressCircular>
        <VCardItem v-else style="min-height: 170px">
          <h2>{{ judulFormatA }}</h2>
          <h3 class="text-secondary mt-5">{{ namaPosyandu }} - {{ kota }}</h3>
          <h4 class="mt-5">
            <font>Lahir: <font class="text-primary">{{ jumlahLahiran }}</font>
            </font>
            <font class="float-right">Meninggal: <font class="text-error">{{ jumlahMeninggal }}</font>
            </font>
          </h4>
        </VCardItem>
      </VCard>
      <VCard class="mt-5">
        <VCardItem>
          <VSelect v-model="tahun" :items="listTahunLahir" />
        </VCardItem>
      </VCard>
    </VCol>
    <VCol cols="12" md="4" sm="12">
      <VCard>
        <VCardItem>
          <VProgressCircular v-if="isLoading" indeterminate color="primary" class="mt-5 float-center" size="50">
          </VProgressCircular>
          <VueApexCharts v-else class="float-center" width="400" :options="chartOptions" :series="series" />
        </VCardItem>
      </VCard>
    </VCol>
    <VCol cols="12">
      <VCard title="Format 1">
        <!-- <VCardText> </VCardText> -->
        <VCardItem>
          <div class="d-flex justify-end">
            <VBtn class="ml-4" href="/data/format-1-create" prepend-icon="bx-plus"> Tambah </VBtn>
            <VBtn class="ml-4" @click="exportExcel" prepend-icon="bx-download"> Download </VBtn>
          </div>
          <VTable>
            <thead>
              <tr>
                <th>No</th>
                <th>Nama Anak</th>
                <th>Tanggal Lahir</th>
                <th>Nama Ayah</th>
                <th>Nama Ibu</th>
                <th style="width: 220px">Aksi</th>
              </tr>
            </thead>

            <tbody>

              <VProgressCircular v-if="isLoading" indeterminate color="primary" class="mt-5 float-center" size="50">
              </VProgressCircular>

              <tr v-else v-for="(item, index) in dataFormatA" :key="item.dessert">
                <td>
                  {{ index + 1 }}
                </td>
                <td>
                  {{ item.nama_bayi }}
                </td>
                <td>
                  {{ item.tanggal_lahir }}
                </td>
                <td class="text-center">
                  {{ item.nama_ayah }}
                </td>
                <td class="text-center">
                  {{ item.nama_ibu }}
                </td>
                <td class="text-center">
                  <v-dialog v-model="dialog[item.id_format_a]" persistent width="1024">
                    <template v-slot:activator="{ props }">
                      <v-btn color="primary" class="ml-2" v-bind="props">
                        <v-icon>mdi-edit</v-icon>
                      </v-btn>
                    </template>
                    <v-card>
                      <v-card-title>
                        <span class="text-h5">Ubah Data</span>
                      </v-card-title>
                      <v-card-text>
                        <v-container>
                          <v-row>
                            <VCol cols="12">
                              <VRow no-gutters>
                                <!-- 👉 First Name -->
                                <VCol cols="12" md="3">
                                  <label for="ayah">Nama Ayah</label>
                                </VCol>

                                <VCol cols="12" md="9">
                                  <VTextField id="ayah" v-model="item.nama_ayah" placeholder="Masukkan Nama Ayah"
                                    persistent-placeholder />
                                  <sup class="text-error">*Wajib diisi</sup>
                                </VCol>
                              </VRow>
                            </VCol>
                            <VCol cols="12">
                              <VRow no-gutters>
                                <!-- 👉 First Name -->
                                <VCol cols="12" md="3">
                                  <label for="ibu">Nama Ibu</label>
                                </VCol>

                                <VCol cols="12" md="9">
                                  <VTextField v-model="item.nama_ibu" id="ibu" placeholder="Masukkan Nama Ibu"
                                    persistent-placeholder />
                                  <sup class="text-error">*Wajib diisi</sup>
                                </VCol>
                              </VRow>
                            </VCol>
                            <VCol cols="12">
                              <VRow no-gutters>
                                <!-- 👉 First Name -->
                                <VCol cols="12" md="3">
                                  <label for="bayi">Nama Bayi</label>
                                </VCol>

                                <VCol cols="12" md="9">
                                  <VTextField v-model="item.nama_bayi" id="bayi" placeholder="Masukkan Nama Bayi"
                                    persistent-placeholder />
                                  <sup class="text-error">*Wajib diisi</sup>
                                </VCol>
                              </VRow>
                            </VCol>
                            <VCol cols="12">
                              <VRow no-gutters>
                                <!-- 👉 First Name -->
                                <VCol cols="12" md="3">
                                  <label for="kelamin">Jenis Kelamin</label>
                                </VCol>

                                <VCol cols="12" md="9">
                                  <VSelect v-model="item.jenis_kelamin" :items="['L', 'P']" />
                                  <sup class="text-error">*Wajib diisi</sup>
                                </VCol>
                              </VRow>
                            </VCol>
                            <VCol cols="12">
                              <VRow no-gutters>
                                <!-- 👉 First Name -->
                                <VCol cols="12" md="3">
                                  <label for="tanggal-lahir">Tanggal Lahir</label>
                                </VCol>

                                <VCol cols="12" md="9">
                                  <VTextField placeholder="" type="date" v-model="item.tanggal_lahir" />
                                  <sup class="text-error">*Wajib diisi</sup>
                                </VCol>
                              </VRow>
                            </VCol>
                            <VCol cols="12">
                              <VRow no-gutters>
                                <!-- 👉 First Name -->
                                <VCol cols="12" md="3">
                                  <label for="tanggal-meninggal-bayi">Tanggal Meninggal Bayi</label>
                                </VCol>

                                <VCol cols="12" md="9">
                                  <VTextField placeholder="" type="date" v-model="item.tanggal_meninggal_bayi" />
                                </VCol>
                              </VRow>
                            </VCol>
                            <VCol cols="12">
                              <VRow no-gutters>
                                <!-- 👉 First Name -->
                                <VCol cols="12" md="3">
                                  <label for="tanggal-meninggal-ibu">Tanggal Meninggal Ibu</label>
                                </VCol>

                                <VCol cols="12" md="9">
                                  <VTextField placeholder="" type="date" v-model="item.tanggal_meninggal_ibu" />
                                </VCol>
                              </VRow>
                            </VCol>
                            <VCol cols="12">
                              <VRow no-gutters>
                                <!-- 👉 First Name -->
                                <VCol cols="12" md="3">
                                  <label for="keterangan">Keterangan</label>
                                </VCol>

                                <VCol cols="12" md="9">
                                  <VTextField v-model="item.keterangan" placeholder="Masukkan Keterangan"
                                    persistent-placeholder />
                                </VCol>
                              </VRow>
                            </VCol>
                          </v-row>
                        </v-container>
                      </v-card-text>
                      <v-card-actions>
                        <v-spacer></v-spacer>
                        <v-btn color="blue-darken-1" variant="text" @click="dialog[item.id_format_a] = false">
                          Close
                        </v-btn>
                        <v-btn color="blue-darken-1" variant="text" @click="
                          putData(index);
                        dialog[item.id_format_a] = false;
                        ">
                          Save
                        </v-btn>
                      </v-card-actions>
                    </v-card>
                  </v-dialog>
                  <!-- <VBtn> </VBtn> -->
                  <VBtn class="ml-2" color="error" @click="deleteData(item.id_format_a)">
                    <v-icon>mdi-delete</v-icon>
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
      <font>Jumlah data: <font class="text-primary">{{ jumlahData }}</font>
      </font>
      <v-pagination class=" float-right" v-model="page" :length="banyakPage" :total-visible="4"
        @click="fetchData"></v-pagination>
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
      dialog: ref([]),
      urlServer: config.urlServer,
      page: 1,
      banyakPage: 5,
      dataFormatA: [],
      judulFormatA: "",
      namaPosyandu: "",
      kota: "",
      jumlahData: 0,
      jumlahLahiran: "",
      jumlahMeninggal: "",
      tahun: d.getFullYear(),
      listTahunLahir: [d.getFullYear()],
      isLoading: false,
      // series: [10, 10, 10],
      // chartOptions: {
      //   chart: {
      //     width: 380,
      //     type: 'pie',
      //   },
      //   legend: {
      //     formatter: function (val, opts) {
      //       return val + " - " + opts.w.globals.series[opts.seriesIndex]
      //     }
      //   },
      //   colors: ['rgba(var(--v-theme-primary), 1)', 'rgba(var(--v-theme-warning), 1)', 'rgba(var(--v-theme-error), 1)'],
      //   labels: ['Bayi Lahir', 'Bayi Meninggal', 'Ibu Meninggal'],
      //   responsive: [{
      //     breakpoint: 480,
      //     options: {
      //       chart: {
      //         width: 200
      //       },
      //       legend: {
      //         position: 'bottom'
      //       }
      //     }
      //   }]
      // },
      series: [{
        data: [0, 0, 0]
      }],
      chartOptions: {
        chart: {
          type: 'bar',
          height: 380
        },
        plotOptions: {
          bar: {
            barHeight: '100%',
            distributed: true,
            horizontal: true,
            dataLabels: {
              position: 'bottom'
            },
          }
        },
        colors: ['rgba(var(--v-theme-primary), 1)', 'rgba(var(--v-theme-warning), 1)', 'rgba(var(--v-theme-error), 1)'
        ],
        dataLabels: {
          enabled: true,
          textAnchor: 'start',
          style: {
            colors: ['#fff']
          },
          formatter: function (val, opt) {
            return opt.w.globals.labels[opt.dataPointIndex] + ":  " + val
          },
          offsetX: 0,
          dropShadow: {
            enabled: true
          }
        },
        stroke: {
          width: 1,
          colors: ['#fff']
        },
        xaxis: {
          categories: [
            'Bayi Lahir', 'Bayi Meninggal', 'Ibu Meninggal'
          ],
        },
        yaxis: {
          labels: {
            show: false
          }
        },
        title: {
          text: 'Custom DataLabels',
          align: 'center',
          floating: true
        },
        subtitle: {
          text: 'Category Names as DataLabels inside bars',
          align: 'center',
        },
        tooltip: {
          theme: 'dark',
          x: {
            show: false
          },
          y: {
            title: {
              formatter: function () {
                return ''
              }
            }
          }
        }
      },
    };
  },

  watch: {
    // Properti tahun akan dipantau
    tahun: function () {
      // Ketika tahun berubah, panggil fungsi fetchData
      this.fetchData();
    }
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

    async putData(indexFormatA) {
      try {
        const data = {
          id_format_a: this.dataFormatA[indexFormatA].id_format_a,
          nama_ayah: this.dataFormatA[indexFormatA].nama_ayah,
          nama_ibu: this.dataFormatA[indexFormatA].nama_ibu,
          nama_bayi: this.dataFormatA[indexFormatA].nama_bayi,
          jenis_kelamin: this.dataFormatA[indexFormatA].jenis_kelamin,
          tanggal_lahir: this.dataFormatA[indexFormatA].tanggal_lahir,
          tanggal_meninggal_bayi:
            this.dataFormatA[indexFormatA].tanggal_meninggal_bayi,
          tanggal_meninggal_ibu:
            this.dataFormatA[indexFormatA].tanggal_meninggal_ibu,
          keterangan: this.dataFormatA[indexFormatA].keterangan,
        };

        const response = await axios.put(
          `${this.urlServer}/api/format-a`,
          data,
          {
            headers: {
              Authorization: localStorage.getItem("tokenAuth"),
            },
          }
        );
        if (response.data.success) {
          Swal.fire({
            toast: true,
            position: "top",
            iconColor: "white",
            color: "white",
            background: "rgb(var(--v-theme-success))",
            showConfirmButton: false,
            timerProgressBar: true,
            timer: 1500,
            icon: "success",
            title: response.data.success.message,
          });
        }
      } catch (error) {
        console.log(error);
      }
    },
    async fetchData() {
      this.isLoading = true;
      const response = await axios.get(
        `${config.urlServer}/api/format-a?length=20&start=${this.page}&tahun=${this.tahun}`,
        {
          headers: {
            Authorization: localStorage.getItem("tokenAuth"),
          },
        }
      );

      this.isLoading = false;

      this.dataFormatA = response.data.format_a;
      this.jumlahLahiran = response.data.jumlah_lahir;
      this.jumlahMeninggal = response.data.jumlah_meninggal;
      // this.series = [
      //   response.data.jumlah_lahir,
      //   response.data.jumlah_bayi_meninggal,
      //   response.data.jumlah_ibu_meninggal,
      // ];
      this.series = [{
        data: [
          response.data.jumlah_lahir,
          response.data.jumlah_bayi_meninggal,
          response.data.jumlah_ibu_meninggal,
        ]
      }]
      this.jumlahData = response.data.jumlah_data;
      return response;

    },
    async deleteData(id_format_a) {
      const ask = await Swal.fire({
        title: "Anda yakin ingin menghapus?",
        showConfirmButton: false,
        showDenyButton: true,
        showCancelButton: true,
        denyButtonText: "Hapus",
      });
      if (ask.isDenied) {
        const response = await axios.delete(
          `${this.urlServer}/api/format-a?id_format_a=${id_format_a}`,
          {
            headers: {
              Authorization: localStorage.getItem("tokenAuth"),
            },
          }
        );
        if (response.data.success) {
          Swal.fire({
            toast: true,
            position: "top",
            iconColor: "white",
            color: "white",
            background: "rgb(var(--v-theme-success))",
            showConfirmButton: false,
            timerProgressBar: true,
            timer: 1500,
            icon: "success",
            title: response.data.success.message,
          });
          this.fetchData();
        }
      }
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
    this.listTahunLahir = response.data.list_tahun_lahir;
  },
};
</script>
