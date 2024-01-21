<template>
  <VRow>
    <VCol cols="12" md="8" sm="12">
      <VCard>
        <VProgressCircular v-if="isLoadingSekali" indeterminate color="primary" class="mt-5 float-center" size="50">
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
          <VSelect v-model="tahun" :items="listTahunLahir" class="mt-5" />
        </VCardItem>
      </VCard>
    </VCol>
    <VCol cols="12" md="4" sm="12">
      <VCard>
        <VCardItem style="min-height: 300px;">
          <VueApexCharts class="float-center" :options="chartOptions" :series="series" />
        </VCardItem>
      </VCard>
    </VCol>
    <VCol cols="12">
      <VCard>
        <!-- <VCardText> </VCardText> -->
        <VCardItem>
          <VRow>
            <VCol cols="12">
              <VTextField v-model="dataSearch" append-inner-icon="bx-search">
              </VTextField>
            </VCol>
            <VCol cols="12">
              <VBtn class="ml-4 mb-3" href="/data/format-1-create" prepend-icon="bx-plus">
                Tambah
              </VBtn>
              <VBtn class="ml-4 mb-3" @click="exportExcel" prepend-icon="bx-download">
                Download
              </VBtn>
            </VCol>
          </VRow>
          <VTable>
            <thead>
              <tr>
                <th>No</th>
                <th>Nama Bayi</th>
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
                  {{ (page - 1) * 20 + (index + 1) }}
                </td>
                <td>
                  {{ item.nama_bayi }}
                </td>
                <td>
                  {{ item.tanggal_lahir_format }}
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
                        <v-icon>bx-edit</v-icon>
                      </v-btn>
                    </template>
                    <v-card>
                      <v-card-title>
                        <span class="text-h5">Ubah Data</span>
                      </v-card-title>
                      <v-card-text>
                        <v-container>
                          <VRow>
                            <VCol cols="12">
                              <h2>Data orang tua</h2>
                              <VRow class="mb-5">
                                <VCol cols="12" md="4" lg="4">
                                  <VRadioGroup v-model="data_tersedia">
                                    <VRadio label="Ubah data" :value="true"></VRadio>
                                  </VRadioGroup>
                                </VCol>
                                <VCol cols="12" md="4" lg="4">
                                  <VRadioGroup v-model="data_tersedia">
                                    <VRadio label="Pilih data lain" :value="false"></VRadio>
                                  </VRadioGroup>
                                </VCol>
                              </VRow>
                              <VRow v-if="data_tersedia">
                                <VCol cols="12">
                                  <VRow no-gutters>
                                    <!-- 👉 First Name -->
                                    <VCol cols="12" md="3">
                                      <label for="ayah">Nama Ayah</label>
                                    </VCol>

                                    <VCol cols="12" md="9">
                                      <VTextField id="ayah" v-model="dataFormatA[index].nama_ayah"
                                        placeholder="Masukkan Nama Ayah..." persistent-placeholder />
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
                                      <VTextField v-model="dataFormatA[index].nama_ibu" id="ibu"
                                        placeholder="Masukkan Nama Ibu..." persistent-placeholder />
                                      <sup class="text-error">*Wajib diisi</sup>
                                    </VCol>
                                  </VRow>
                                </VCol>
                                <VCol cols="12">
                                  <VRow no-gutters>
                                    <!-- 👉 First Name -->
                                    <VCol cols="12" md="3">
                                      <label for="nik_ibu">NIK Ayah</label>
                                    </VCol>

                                    <VCol cols="12" md="9">
                                      <VTextField v-model="dataFormatA[index].nik_ayah" id="nik_ayah"
                                        placeholder="Masukkan NIK Ayah..." persistent-placeholder />
                                    </VCol>
                                  </VRow>
                                </VCol>
                                <VCol cols="12">
                                  <VRow no-gutters>
                                    <!-- 👉 First Name -->
                                    <VCol cols="12" md="3">
                                      <label for="nik_ibu">NIK Ibu</label>
                                    </VCol>

                                    <VCol cols="12" md="9">
                                      <VTextField v-model="dataFormatA[index].nik_ibu" id="nik_ibu"
                                        placeholder="Masukkan NIK Ibu..." persistent-placeholder />
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
                                      <VTextField placeholder="" type="date"
                                        v-model="dataFormatA[index].tanggal_meninggal_ibu" />
                                    </VCol>
                                  </VRow>
                                </VCol>
                                <VCol cols="12">
                                  <VRow no-gutters>
                                    <!-- 👉 First Name -->
                                    <VCol cols="12" md="3">
                                      <label>Nomor yang bisa dihubungi</label>
                                    </VCol>

                                    <VCol cols="12" md="9">
                                      <VTextField v-model="dataFormatA[index].no_telp" placeholder="08xx"
                                        persistent-placeholder />
                                    </VCol>
                                  </VRow>
                                </VCol>
                                <VCol cols="12">
                                  <VRow no-gutters>
                                    <!-- 👉 First Name -->
                                    <VCol cols="12" md="3">
                                      <label>RT/RW</label>
                                    </VCol>

                                    <VCol cols="12" md="9">
                                      <VTextField v-model="dataFormatA[index].rt_rw" placeholder="Masukkan RT/RW..."
                                        persistent-placeholder />
                                    </VCol>
                                  </VRow>
                                </VCol>
                                <VCol cols="12">
                                  <VRow no-gutters>
                                    <!-- 👉 First Name -->
                                    <VCol cols="12" md="3">
                                      <label for="ibu">Tempat Tinggal</label>
                                    </VCol>

                                    <VCol cols="12" md="9">
                                      <VTextarea placeholder="Alamat tempat tinggal..."
                                        v-model="dataFormatA[index].tempat_tinggal" />
                                    </VCol>
                                  </VRow>
                                </VCol>
                              </VRow>
                              <VRow v-else>
                                <VCol cols="12">
                                  <VAutocomplete v-model="ganti_id_ortu" label="Nama orang tua...." :items="listOrangTua">
                                  </VAutocomplete>
                                </VCol>
                              </VRow>
                            </VCol>
                            <VCol cols="12">
                              <h2>Data bayi</h2>
                              <VRow no-gutters>
                                <!-- 👉 First Name -->
                                <VCol cols="12" md="3">
                                  <label for="bayi">Nama Bayi</label>
                                </VCol>

                                <VCol cols="12" md="9">
                                  <VTextField v-model="dataFormatA[index].nama_bayi" id="bayi"
                                    placeholder="Masukkan Nama Bayi..." persistent-placeholder />
                                  <sup class="text-error">*Wajib diisi</sup>
                                </VCol>
                              </VRow>
                            </VCol>
                            <VCol cols="12">
                              <VRow no-gutters>
                                <!-- 👉 First Name -->
                                <VCol cols="12" md="3">
                                  <label for="nik_bayi">NIK bayi</label>
                                </VCol>

                                <VCol cols="12" md="9">
                                  <VTextField v-model="dataFormatA[index].nik_bayi" id="nik_bayi"
                                    placeholder="Masukkan NIK bayi..." persistent-placeholder />
                                </VCol>
                              </VRow>
                            </VCol>
                            <VCol cols="12">
                              <VRow no-gutters>
                                <!-- 👉 First Name -->
                                <VCol cols="12" md="3">
                                  <label>Anak ke berapa?</label>
                                </VCol>

                                <VCol cols="12" md="9">
                                  <VTextField v-model="dataFormatA[index].anak_ke" type="number"
                                    placeholder="Masukkan panjang Lahir..." persistent-placeholder />
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
                                  <VSelect v-model="dataFormatA[index].jenis_kelamin" :items="['L', 'P']"
                                    placeholder="Pilih jenis kelamin.." />
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
                                  <VTextField placeholder="" type="date" v-model="dataFormatA[index].tanggal_lahir" />
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
                                  <VTextField placeholder="" type="date"
                                    v-model="dataFormatA[index].tanggal_meninggal_bayi" />
                                </VCol>
                              </VRow>
                            </VCol>
                            <VCol cols="12">
                              <VRow no-gutters>
                                <!-- 👉 First Name -->
                                <VCol cols="12" md="3">
                                  <label>Berat Lahir</label>
                                </VCol>

                                <VCol cols="12" md="9">
                                  <VTextField v-model="dataFormatA[index].berat_lahir" type="number"
                                    placeholder="Masukkan Berat Lahir..." persistent-placeholder />
                                </VCol>
                              </VRow>
                            </VCol>
                            <VCol cols="12">
                              <VRow no-gutters>
                                <!-- 👉 First Name -->
                                <VCol cols="12" md="3">
                                  <label>Panjang saat lahir</label>
                                </VCol>

                                <VCol cols="12" md="9">
                                  <VTextField v-model="dataFormatA[index].tinggi_lahir" type="number"
                                    placeholder="Masukkan panjang Lahir..." persistent-placeholder />
                                </VCol>
                              </VRow>
                            </VCol>
                            <VCol cols="12">
                              <VRow no-gutters>
                                <!-- 👉 First Name -->
                                <VCol cols="12" md="3">
                                  <label>Memiliki KIA</label>
                                </VCol>

                                <VCol cols="12" md="9">
                                  <VCheckbox v-model="dataFormatA[index].memiliki_kia" :label="`Ya`" />
                                </VCol>
                              </VRow>
                            </VCol>
                            <VCol cols="12">
                              <VRow no-gutters>
                                <!-- 👉 First Name -->
                                <VCol cols="12" md="3">
                                  <label>IMD</label>
                                </VCol>

                                <VCol cols="12" md="9">
                                  <VCheckbox v-model="dataFormatA[index].imd" :label="`Ya`" />
                                </VCol>
                              </VRow>
                            </VCol>
                            <VCol cols="12">
                              <VRow no-gutters>
                                <!-- 👉 First Name -->
                                <VCol cols="12" md="3">
                                  <label>Memiliki KMS</label>
                                </VCol>

                                <VCol cols="12" md="9">
                                  <VCheckbox v-model="dataFormatA[index].memiliki_kms" :label="`Ya`" />
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
                                  <VTextField v-model="dataFormatA[index].keterangan" placeholder="Masukkan Keterangan"
                                    persistent-placeholder />
                                </VCol>
                              </VRow>
                            </VCol>
                          </VRow>
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

                  <VBtn class="ml-2" color="error" @click="deleteData(item.id_format_a)">
                    <v-icon>bx-trash</v-icon>
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
      <v-pagination class="float-right" v-model="page" :length="banyakPage" :total-visible="4"
        @click="gantiPage"></v-pagination>
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
      listOrangTua: [],
      data_tersedia: true,
      pilihOrangTua: null,
      ganti_id_ortu: null,
      dataSearch: "",
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
      isLoadingSekali: false,
      series: [
        {
          data: [0, 0],
        },
      ],
      chartOptions: {
        chart: {
          type: "bar",
        },
        plotOptions: {
          bar: {
            barHeight: "100%",
            distributed: true,
            horizontal: true,
            dataLabels: {
              position: "bottom",
            },
          },
        },
        colors: [
          "#696cff",
          "#ff3e1d",
        ],
        dataLabels: {
          enabled: true,
          textAnchor: "start",
          style: {
            colors: ["#fff"],
          },
          formatter: function (val, opt) {
            return opt.w.globals.labels[opt.dataPointIndex] + ":  " + val;
          },
          offsetX: 0,
          dropShadow: {
            enabled: true,
          },
        },
        xaxis: {
          categories: ["Bayi Lahir", "Bayi Meninggal"],
        },
        yaxis: {
          labels: {
            show: false,
          },
        },
        title: {
          text: "Data Pertumbuhan Penduduk",
          align: "center",
          floating: true,
        },
        tooltip: {
          theme: "dark",
          x: {
            show: false,
          },
        },
      },
    };
  },

  watch: {
    // Properti tahun akan dipantau
    tahun: async function () {
      // Ketika tahun berubah, panggil fungsi fetchData
      this.page = 1;
      const response = await this.fetchData();
      this.jumlahLahiran = response.data.jumlah_lahir;
      this.jumlahMeninggal = response.data.jumlah_meninggal;
      this.series = [
        {
          data: [
            response.data.jumlah_lahir,
            response.data.jumlah_bayi_meninggal,
          ],
        },
      ];
      this.jumlahData = response.data.jumlah_data;
      this.dataSearch = "";
    },
    dataSearch: function () {
      this.fetchData();
    },
  },
  methods: {
    async fetchListOrtu() {

      const response = await axios.get(`${config.urlServer}/api/list-orang-tua`,
        {
          headers: {
            Authorization: localStorage.getItem("tokenAuth"),
          },
        });
      this.listOrangTua = response.data;
    },
    gantiPage() {
      this.fetchData();
    },
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
          ganti_id_ortu: this.data_tersedia ? null : this.ganti_id_ortu,
          nama_ayah: this.dataFormatA[indexFormatA].nama_ayah,
          nama_ibu: this.dataFormatA[indexFormatA].nama_ibu,
          nik_ayah: this.dataFormatA[indexFormatA].nik_ayah,
          nik_ibu: this.dataFormatA[indexFormatA].nik_ibu,
          tanggal_meninggal_ibu: this.dataFormatA[indexFormatA].tanggal_meninggal_ibu,
          no_telp: this.dataFormatA[indexFormatA].no_telp,
          rt_rw: this.dataFormatA[indexFormatA].rt_rw,
          tempat_tinggal: this.dataFormatA[indexFormatA].tempat_tinggal,
          nama_bayi: this.dataFormatA[indexFormatA].nama_bayi,
          nik_bayi: this.dataFormatA[indexFormatA].nik_bayi,
          anak_ke: this.dataFormatA[indexFormatA].anak_ke,
          jenis_kelamin: this.dataFormatA[indexFormatA].jenis_kelamin,
          tanggal_lahir: this.dataFormatA[indexFormatA].tanggal_lahir,
          tanggal_meninggal_bayi: this.dataFormatA[indexFormatA].tanggal_meninggal_bayi,
          berat_lahir: this.dataFormatA[indexFormatA].berat_lahir,
          tinggi_lahir: this.dataFormatA[indexFormatA].tinggi_lahir,
          memiliki_kia: this.dataFormatA[indexFormatA].memiliki_kia,
          imd: this.dataFormatA[indexFormatA].imd,
          memiliki_kms: this.dataFormatA[indexFormatA].memiliki_kms,
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
        console.log(error)
        Swal.fire({
          toast: true,
          position: "top",
          iconColor: "white",
          color: "white",
          background: "rgb(var(--v-theme-error))",
          showConfirmButton: false,
          timerProgressBar: true,
          timer: 4000,
          icon: "error",
          title: "Data Tidak Lengkap atau Salah",
        });
      }
    },

    async fetchData() {
      this.isLoading = true;
      const response = await axios.get(
        `${config.urlServer}/api/format-a?length=20&start=${this.page}&tahun=${this.tahun}&search=${this.dataSearch}`,
        {
          headers: {
            Authorization: localStorage.getItem("tokenAuth"),
          },
        }
      );

      this.isLoading = false;
      this.dataFormatA = response.data.format_a;
      this.jumlahData = response.data.jumlah_data;
      this.banyakPage = Math.ceil(response.data.jumlah_data / 20);
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
    this.fetchListOrtu();
    const response = await this.fetchData();
    this.judulFormatA = response.data.judul_format;
    this.namaPosyandu = response.data.nama_posyandu;
    this.kota = response.data.kota;
    this.listTahunLahir = response.data.list_tahun_lahir;
    this.jumlahLahiran = response.data.jumlah_lahir;
    this.jumlahMeninggal = response.data.jumlah_meninggal;
    this.series = [
      {
        data: [
          response.data.jumlah_lahir,
          response.data.jumlah_bayi_meninggal,
        ],
      },
    ];
  },
};
</script>
