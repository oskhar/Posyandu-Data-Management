<template>
  <VRow>
    <VCol cols="12">
      <VCard>
        <VProgressCircular v-if="isLoadingHeader" indeterminate color="primary" class="mt-5 float-center" size="50">
        </VProgressCircular>
        <VCardItem v-else style="min-height: 170px">
          <h2>{{ judulFormatC }}</h2>
          <h3 class="text-secondary mt-5">{{ namaPosyandu }} - {{ kota }}</h3>
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
              <VBtn class="mb-3" href="/admin/data/format-3-create" prepend-icon="bx-plus">
                Tambah
              </VBtn>
              <!--
                <VBtn
                class="ml-4 mb-3"
                @click="exportExcel"
                prepend-icon="bx-download"
                >
                Download
                </VBtn> 
              -->
            </VCol>
          </VRow>
          <VTable>
            <thead>
              <tr>
                <th>No</th>
                <th>Nama Wus & Pus</th>
                <th>Umur</th>
                <th>Nama Suami</th>
                <th>Tahapan KS</th>
                <th style="width: 220px">Aksi</th>
              </tr>
            </thead>

            <tbody>
              <VProgressCircular v-if="isLoadingTable" indeterminate color="primary" class="mt-5 float-center"
                size="50">
              </VProgressCircular>

              <tr v-for="(item, index) in dataFormatC" v-else :key="item.dessert">
                <td>
                  {{ (page - 1) * 20 + (index + 1) }}
                </td>
                <td>
                  {{ item.nama_ibu }}
                </td>
                <td class="text-center">{{ item.umur }} Tahun</td>
                <td class="text-center">
                  {{ item.nama_ayah }}
                </td>
                <td class="text-center">
                  {{ item.tahapan_ks }}
                </td>
                <td class="text-center">
                  <VDialog v-model="dialog[index]" persistent width="1024">
                    <template #activator="{ props }">
                      <VBtn color="primary" class="ml-2" v-bind="props">
                        <VIcon>bx-edit</VIcon>
                      </VBtn>
                    </template>
                    <VCard>
                      <VCardTitle>
                        <span class="text-h5">Ubah Data</span>
                      </VCardTitle>
                      <VCardItem>
                        <VRow>
                          <VCol cols="12">
                            <h2>Data orang tua</h2>
                            <VRow class="mb-5">
                              <VCol cols="12" md="4" lg="4">
                                <VRadioGroup v-model="data_tersedia">
                                  <VRadio label="Ubah data" :value></VRadio>
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
                                    <VTextField id="ayah" v-model="dataFormatC[index].nama_ayah"
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
                                    <VTextField id="ibu" v-model="dataFormatC[index].nama_ibu"
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
                                    <VTextField id="nik_ayah" v-model="dataFormatC[index].nik_ayah"
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
                                    <VTextField id="nik_ibu" v-model="dataFormatC[index].nik_ibu"
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
                                    <VTextField v-model="dataFormatC[index].tanggal_meninggal_ibu
                                      " placeholder="" type="date" />
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
                                    <VTextField v-model="dataFormatC[index].no_telp" placeholder="08xx"
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
                                    <VTextField v-model="dataFormatC[index].rt_rw" placeholder="Masukkan RT/RW..."
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
                                    <VTextarea v-model="dataFormatC[index].tempat_tinggal
                                      " placeholder="Alamat tempat tinggal..." />
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
                            <VRow>
                              <VCol cols="12">
                                <h2>Data wus & pus</h2>
                                <VRow no-gutters>
                                  <!-- 👉 First Name -->
                                  <VCol cols="12" md="3">
                                    <label for="umur">Umur WUS dan PUS</label>
                                  </VCol>

                                  <VCol cols="12" md="9">
                                    <VTextField id="umur" v-model="dataFormatC[index].umur" placeholder="tahun.."
                                      persistent-placeholder type="number" />
                                    <sup class="text-error">*Wajib diisi</sup>
                                  </VCol>
                                </VRow>
                              </VCol>
                              <VCol cols="12">
                                <VRow no-gutters>
                                  <!-- 👉 First Name -->
                                  <VCol cols="12" md="3">
                                    <label for="ks">Tahapan KS</label>
                                  </VCol>

                                  <VCol cols="12" md="9">
                                    <VTextField id="ks" v-model="dataFormatC[index].tahapan_ks"
                                      placeholder="Tahapan KS.." persistent-placeholder />
                                    <sup class="text-error">*Wajib diisi</sup>
                                  </VCol>
                                </VRow>
                              </VCol>
                              <VCol cols="12">
                                <VRow no-gutters>
                                  <!-- 👉 First Name -->
                                  <VCol cols="12" md="3">
                                    <label for="dasawisma">Kelompok Dasawisma</label>
                                  </VCol>

                                  <VCol cols="12" md="9">
                                    <VTextField id="dasawisma" v-model="dataFormatC[index].kelompok_dasawisma
                                      " placeholder="Kelompok dasawisma.." persistent-placeholder />
                                    <sup class="text-error">*Wajib diisi</sup>
                                  </VCol>
                                </VRow>
                              </VCol>
                              <VCol cols="12">
                                <VRow no-gutters>
                                  <!-- 👉 First Name -->
                                  <VCol cols="12" md="3">
                                    <label for="lila">Ukuran LILA</label>
                                  </VCol>

                                  <VCol cols="12" md="9">
                                    <VTextField id="lila" v-model="dataFormatC[index].lila" placeholder="cm.."
                                      persistent-placeholder type="number" />
                                    <sup class="text-error">*Wajib diisi</sup>
                                  </VCol>
                                </VRow>
                              </VCol>
                              <VCol cols="12">
                                <VRow no-gutters>
                                  <!-- 👉 First Name -->
                                  <VCol cols="12" md="3">
                                    <label for="tanggal-lahir">Jumlah anak</label>
                                  </VCol>

                                  <VCol cols="6" md="4">
                                    <VTextField v-model="dataFormatC[index].jumlah_anak_hidup
                                      " placeholder="Hidup.." />
                                    <sup class="text-error">*Wajib diisi</sup>
                                  </VCol>

                                  <VCol cols="6" class="ml-5" md="4">
                                    <VTextField v-model="dataFormatC[index].jumlah_anak_meninggal
                                      " placeholder="Meninggal.." />
                                    <sup class="text-error">*Wajib diisi</sup>
                                  </VCol>
                                </VRow>
                              </VCol>
                              <VCol cols="12">
                                <VRow no-gutters>
                                  <!-- 👉 First Name -->
                                  <VCol cols="12" md="3">
                                    <label for="imunisasi">Imunisasi</label>
                                  </VCol>

                                  <VCol cols="12" md="9">
                                    <VSelect v-model="dataFormatC[index].imunisasi" :items="itemImunisasi"
                                      label="imunisasi" placeholder="Pilih beberapa" multiple chips>
                                      <template #prepend-item>
                                        <VListItem ripple @mousedown.prevent @click="toggleHasil(index)">
                                          <VListItemAction>
                                            <VIcon :color="dataFormatC[index].imunisasi
                                                .length ===
                                                itemImunisasi.length
                                                ? 'primary'
                                                : 'secondary'
                                              ">
                                              {{ iconHasil(index) }}
                                            </VIcon>
                                            <Font class="ml-2">
                                              Pilih Semua
                                            </Font>
                                          </VListItemAction>
                                        </VListItem>
                                        <VDivider class="mt-2"></VDivider>
                                      </template>
                                    </VSelect>
                                  </VCol>
                                </VRow>
                              </VCol>
                              <VCol cols="12">
                                <VRow no-gutters>
                                  <!-- 👉 First Name -->
                                  <VCol cols="12" md="3">
                                    <label for="kontrasepsi">Jenis Kontrasepsi</label>
                                  </VCol>

                                  <VCol cols="12" md="9">
                                    <VTextField id="kontrasepsi" v-model="dataFormatC[index].jenis_kontrasepsi
                                      " placeholder="jenis.." persistent-placeholder />
                                    <sup class="text-error">*Wajib diisi</sup>
                                  </VCol>
                                </VRow>
                              </VCol>
                              <VCol cols="12">
                                <VRow no-gutters>
                                  <!-- 👉 First Name -->
                                  <VCol cols="12" md="3">
                                    <label for="penggantian">Tanggal Penggantian</label>
                                  </VCol>

                                  <VCol cols="12" md="9">
                                    <VTextField id="penggantian" v-model="dataFormatC[index].tanggal_penggantian
                                      " placeholder="Tanggal Penggantian.." persistent-placeholder type="date" />
                                    <sup class="text-error">*Wajib diisi</sup>
                                  </VCol>
                                </VRow>
                              </VCol>
                              <VCol cols="12">
                                <VRow no-gutters>
                                  <!-- 👉 First Name -->
                                  <VCol cols="12" md="3">
                                    <label for="kontrasepsi">Penggantian</label>
                                  </VCol>

                                  <VCol cols="12" md="9">
                                    <VTextField id="kontrasepsi" v-model="dataFormatC[index]
                                        .penggantian_jenis_kontrasepsi
                                      " placeholder="jenis kontrasepsi.." persistent-placeholder />
                                    <sup class="text-error">*Wajib diisi</sup>
                                  </VCol>
                                </VRow>
                              </VCol>
                            </VRow>
                          </VCol>
                        </VRow>
                      </VCardItem>
                      <VCardActions>
                        <VSpacer></VSpacer>
                        <VBtn color="blue-darken-1" variant="text" @click="dialog[index] = false">
                          Tutup
                        </VBtn>
                        <VBtn color="blue-darken-1" variant="text" @click="
                          putData(index);
                        dialog[index] = false;
                        ">
                          Simpan
                        </VBtn>
                      </VCardActions>
                    </VCard>
                  </VDialog>

                  <VBtn class="ml-2" color="error" @click="deleteData(item.id_format_c)">
                    <VIcon>bx-trash</VIcon>
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
      <Font>Jumlah data: <Font class="text-primary">{{ jumlahData }}</Font>
      </Font>
      <VPagination v-model="page" class="float-right" :length="banyakPage" :total-visible="4" @click="fetchData">
      </VPagination>
    </VCol>
  </VRow>
</template>

<script>
import axios from "axios";
import AnalyticsBarCharts from "@/views/dashboard/AnalyticsBarCharts.vue";
import config from "@/@core/config";
import VueApexCharts from "vue3-apexcharts";
import Swal from "sweetalert2";

export default {
  data() {
    const d = new Date();

    return {
      dialog: [],
      data_tersedia: true,
      ganti_id_ortu: null,
      dataSearch: "",
      listOrangTua: [],
      urlServer: config.urlServer,
      page: 1,
      banyakPage: 5,
      dataFormatC: [],
      judulFormatC: "",
      namaPosyandu: "",
      kota: "",
      jumlahData: 0,
      jumlahLahiran: "",
      jumlahMeninggal: "",
      tahun: d.getFullYear(),
      listTahunLahir: [d.getFullYear()],
      isLoadingTable: false,
      isLoadingHeader: false,
      chartOptions: {},
      itemImunisasi: [
        "Imunisasi I",
        "Imunisasi II",
        "Imunisasi III",
        "Imunisasi IV",
        "Imunisasi V",
      ],
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
  async mounted() {
    this.fetchListOrtu();
    this.isLoadingHeader = true;

    const response = await this.fetchData();

    this.judulFormatC = response.data.judul_format;
    this.namaPosyandu = response.data.nama_posyandu;
    this.kota = response.data.kota;

    const response2 = await axios.get(
      `${config.urlServer}/api/listtahun?tab=1`,
      {
        headers: {
          Authorization: localStorage.getItem("tokenAuth"),
        },
      },
    );

    this.listTahunLahir = response2.data;
    this.isLoadingHeader = false;
  },
  methods: {
    pilihSemuaHasil(index) {
      return (
        this.dataFormatC[index].imunisasi.length === this.itemImunisasi.length
      );
    },
    iconHasil(index) {
      if (this.pilihSemuaHasil(index)) return "mdi-close-box";

      return "mdi-checkbox-blank-outline";
    },
    toggleHasil(index) {
      this.$nextTick(() => {
        if (this.pilihSemuaHasil(index)) {
          this.dataFormatC[index].imunisasi = [];
        } else {
          this.dataFormatC[index].imunisasi = this.itemImunisasi.slice();
        }
      });
    },
    async fetchListOrtu() {
      const response = await axios.get(
        `${config.urlServer}/api/list-orang-tua`,
        {
          headers: {
            Authorization: localStorage.getItem("tokenAuth"),
          },
        },
      );

      this.listOrangTua = response.data;
    },
    async exportExcel() {
      try {
        const response = await axios({
          method: "get",
          url: `${this.urlServer}/api/export/format-c?tahun=${this.tahun}`,
          responseType: "blob",
          headers: {
            Authorization: localStorage.getItem("tokenAuth"),
          },
        });
      } catch (error) {
        console.log(error);
      }

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
      const namaFile = `Format-2_tab-1${currentDateTime}.xlsx`;

      const url = window.URL.createObjectURL(new Blob([response.data]));
      const link = document.createElement("a");

      link.href = url;
      link.setAttribute("download", namaFile);
      document.body.appendChild(link);
      link.click();
    },
    async fetchData() {
      this.isLoadingTable = true;

      const response = await axios.get(
        `${config.urlServer}/api/format-c?length=20&start=${this.page}&tahun=${this.tahun}&search=${this.dataSearch}&tab=1`,
        {
          headers: {
            Authorization: localStorage.getItem("tokenAuth"),
          },
        },
      );

      this.banyakPage = Math.ceil(response.data.jumlah_data / 20);
      this.jumlahData = response.data.jumlah_data;
      this.dataFormatC = response.data.format_c;
      this.isLoadingTable = false;

      return response;
    },

    async putData(indexFormatC) {
      try {
        this.dataFormatC[indexFormatC].ganti_id_ortu = this.data_tersedia
          ? null
          : this.ganti_id_ortu;

        const response = await axios.put(
          `${this.urlServer}/api/format-c`,
          this.dataFormatC[indexFormatC],
          {
            headers: {
              Authorization: localStorage.getItem("tokenAuth"),
            },
          },
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

    async deleteData(id_format_c) {
      const ask = await Swal.fire({
        title: "Anda yakin ingin menghapus?",
        showConfirmButton: false,
        showDenyButton: true,
        showCancelButton: true,
        denyButtonText: "Hapus",
      });

      if (ask.isDenied) {
        const response = await axios.delete(
          `${this.urlServer}/api/format-c?id_format_c=${id_format_c}`,
          {
            headers: {
              Authorization: localStorage.getItem("tokenAuth"),
            },
          },
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
};
</script>
