<template>
  <VRow>
    <VCol md="9" sm="12">
      <VCard>
        <VCardItem style="min-height: 170px">
          <h1 class="text-primary">{{ judulFormatA }} {{ tahun }}</h1>
          <h2 class="">{{ namaPosyandu }} - {{ kota }}</h2>
          <h2 class="">Jumlah Kelahiran: {{ jumlahKelahiran }}</h2>
          <h2 class="">Jumlah Kematian: {{ jumlahKematian }}</h2>
        </VCardItem>
      </VCard>
    </VCol>
    <VCol md="3" sm="12">
      <AnalyticsBarCharts title="Data"></AnalyticsBarCharts>
    </VCol>

    <VCol cols="12">
      <VCard title="Format 1">
        <!-- <VCardText> </VCardText> -->
        <VCardItem>
          <div class="d-flex justify-end">
            <VBtn class="ml-4" href="/data/format-1-create"> Tambah </VBtn>
            <VBtn class="ml-4" @click="exportExcel"> Export </VBtn>
            <!-- @click="exportExcel" -->
            <VBtn class="ml-4" href="/data/format-1-import"> Import </VBtn>
          </div>
          <VTable>
            <thead>
              <tr>
                <th class="text-uppercase">Nama Anak</th>
                <th>Nama Ayah</th>
                <th>Nama Ibu</th>
                <th style="width: 220px">Aksi</th>
              </tr>
            </thead>

            <tbody>
              <tr v-for="(item, index) in dataFormatA" :key="item.dessert">
                <td>
                  {{ item.nama_bayi }}
                </td>
                <td class="text-center">
                  {{ item.nama_ayah }}
                </td>
                <td class="text-center">
                  {{ item.nama_ibu }}
                </td>
                <td class="text-center">
                  <v-dialog
                    v-model="dialog[item.id_format_a]"
                    persistent
                    width="1024"
                  >
                    <template v-slot:activator="{ props }">
                      <v-btn color="primary" v-bind="props">
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
                                  <VTextField
                                    id="ayah"
                                    v-model="item.nama_ayah"
                                    placeholder="Masukkan Nama Ayah"
                                    persistent-placeholder
                                  />
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
                                  <VTextField
                                    v-model="item.nama_ibu"
                                    id="ibu"
                                    placeholder="Masukkan Nama Ibu"
                                    persistent-placeholder
                                  />
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
                                  <VTextField
                                    v-model="item.nama_bayi"
                                    id="bayi"
                                    placeholder="Masukkan Nama Bayi"
                                    persistent-placeholder
                                  />
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
                                  <VSelect
                                    v-model="item.jenis_kelamin"
                                    :items="['L', 'P']"
                                  />
                                  <sup class="text-error">*Wajib diisi</sup>
                                </VCol>
                              </VRow>
                            </VCol>
                            <VCol cols="12">
                              <VRow no-gutters>
                                <!-- 👉 First Name -->
                                <VCol cols="12" md="3">
                                  <label for="tanggal-lahir"
                                    >Tanggal Lahir</label
                                  >
                                </VCol>

                                <VCol cols="12" md="9">
                                  <VTextField
                                    placeholder=""
                                    type="date"
                                    v-model="item.tanggal_lahir"
                                  />
                                  <sup class="text-error">*Wajib diisi</sup>
                                </VCol>
                              </VRow>
                            </VCol>
                            <VCol cols="12">
                              <VRow no-gutters>
                                <!-- 👉 First Name -->
                                <VCol cols="12" md="3">
                                  <label for="tanggal-meninggal-bayi"
                                    >Tanggal Meninggal Bayi</label
                                  >
                                </VCol>

                                <VCol cols="12" md="9">
                                  <VTextField
                                    placeholder=""
                                    type="date"
                                    v-model="item.tanggal_meninggal_bayi"
                                  />
                                </VCol>
                              </VRow>
                            </VCol>
                            <VCol cols="12">
                              <VRow no-gutters>
                                <!-- 👉 First Name -->
                                <VCol cols="12" md="3">
                                  <label for="tanggal-meninggal-ibu"
                                    >Tanggal Meninggal Ibu</label
                                  >
                                </VCol>

                                <VCol cols="12" md="9">
                                  <VTextField
                                    placeholder=""
                                    type="date"
                                    v-model="item.tanggal_meninggal_ibu"
                                  />
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
                                  <VTextField
                                    v-model="item.keterangan"
                                    placeholder="Masukkan Keterangan"
                                    persistent-placeholder
                                  />
                                </VCol>
                              </VRow>
                            </VCol>
                          </v-row>
                        </v-container>
                      </v-card-text>
                      <v-card-actions>
                        <v-spacer></v-spacer>
                        <v-btn
                          color="blue-darken-1"
                          variant="text"
                          @click="dialog[item.id_format_a] = false"
                        >
                          Close
                        </v-btn>
                        <v-btn
                          color="blue-darken-1"
                          variant="text"
                          @click="
                            putData(index);
                            dialog[item.id_format_a] = false;
                          "
                        >
                          Save
                        </v-btn>
                      </v-card-actions>
                    </v-card>
                  </v-dialog>
                  <!-- <VBtn> </VBtn> -->
                  <VBtn
                    class="ml-2"
                    color="error"
                    @click="deleteData(item.id_format_a)"
                  >
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
      <div class="text-center my-3 float-right">
        <v-pagination
          v-model="page"
          :length="banyakPage"
          :total-visible="4"
          @click="fetchData"
        ></v-pagination>
      </div>
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

export default {
  data() {
    const d = new Date();
    return {
      dialog: ref([]),
      urlServer: config.urlServer,
      refInput: ref(),
      page: 1,
      banyakPage: 5,
      dataFormatA: [],
      judulFormatA: "",
      namaPosyandu: "",
      kota: "",
      jumlahKelahiran: "gg",
      jumlahKematian: "",
      tahun: d.getFullYear(),
    };
  },

  methods: {
    async exportExcel() {
      const response = await axios({
        method: "get",
        url: `${this.urlServer}/api/export/format-a`,
        responseType: "blob",
        headers: {
          Authorization: localStorage.getItem("tokenAuth"),
        },
      });

      // Get the namaFile from the Content-Disposition header
      const namaFile = "Format-1.xlsx";

      console.log(response);
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
      const response = await axios.get(
        `${config.urlServer}/api/format-a?length=20&start=${this.page}`,
        {
          headers: {
            Authorization: localStorage.getItem("tokenAuth"),
          },
        }
      );
      this.dataFormatA = response.data.format_a;
      this.banyakPage = Math.ceil(response.data.jumlah_data / 20);
      this.judulFormatA = response.data.judul_format;
      this.namaPosyandu = response.data.nama_posyandu;
      this.kota = response.data.kota;
      this.jumlahKelahiran = response.data.jumlah_kelahiran;
      this.jumlahKematian = response.data.jumlah_kematian;
      console.log(this.jumlahKematian);
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
  },
  mounted() {
    this.fetchData();
  },
};
</script>
