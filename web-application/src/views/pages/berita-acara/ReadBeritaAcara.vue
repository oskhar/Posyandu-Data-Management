<template>
  <VRow>
    <VCol cols="12" md="12" sm="12" v-if="isLoading" class="text-center">
      <VProgressCircular indeterminate color="primary" class="mt-5" size="50"></VProgressCircular>
    </VCol>
    <!-- 👉 Popular Uses Of The Internet -->
    <VCol v-else v-for="(data, index) in dataBerita" cols="12" md="4" sm="12">
      <VCard>
        <VImg :src="data.gambar" cover style="height: 280px">
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

          <v-row justify="center">
            <v-dialog v-model="dialog[data.id_berita]" persistent width="1024">
              <template v-slot:activator="{ props }">
                <VRow class="mt-3">
                  <VCol>
                    <!-- <VBtn> Lihat </VBtn> -->

                    <VBtn color="primary" class="mx-3" v-bind="props">
                      Edit & Lihat
                    </VBtn>
                    <VBtn color="error" @click="deleteBerita(data.id_berita)" class="float-right">
                      <v-icon>bx-trash</v-icon>
                    </VBtn>
                  </VCol>
                </VRow>
              </template>
              <v-card>
                <v-card-title>
                  <div class="text-h5">Edit</div>
                </v-card-title>
                <v-card-text>
                  <v-container>
                    <!-- <p class="">Perubahan Otomatis Tersimpan</p> -->
                    <v-row>
                      <v-col cols="12">
                        <VTextField id="judul" v-model="data.judul" placeholder="Masukkan Judul" persistent-placeholder />
                      </v-col>
                      <v-col cols="12">
                        <VTextarea id="deskripsi" v-model="data.deskripsi" placeholder="Masukkan Isi Materi"
                          persistent-placeholder />
                      </v-col>
                      <VCol cols="12">
                        <VTextField type="date" id="tanggal" v-model="data.tanggal_pelaksanaan"
                          placeholder="Masukkan tanggal" persistent-placeholder />
                      </VCol>
                      <v-col cols="12">
                        <!-- <VImg :src="urlServer + data.gambar" :width="110" /> -->
                      </v-col>
                      <VCol cols="12" md="9">
                        <div class="d-flex flex-column justify-center gap-5">
                          <div class="d-flex flex-wrap gap-2">
                            <VBtn id="gambar" color="primary" @click="inputGambar">
                              <VIcon icon="bx-cloud-upload" class="d-sm-none" />
                              <span class="d-none d-sm-block">Upload foto baru</span>
                            </VBtn>

                            <input id="inputGambar" :ref="data.refInput" type="file" name="file" accept=".jpeg,.png,.jpg"
                              hidden @change="changeAvatar($event, index)" />
                          </div>
                        </div>
                        <VAvatar rounded="lg" size="200" class="me-1 mt-3" :image="data.gambar"
                          v-show="data.gambar !== ''" />
                      </VCol>
                    </v-row>
                  </v-container>
                </v-card-text>
                <v-card-actions>
                  <v-spacer></v-spacer>
                  <v-btn color="blue-darken-1" variant="text" @click="dialog[data.id_berita] = false">
                    Tutup
                  </v-btn>
                  <v-btn color="blue-darken-1" variant="text" @click="
                    putData(index);
                  dialog[data.id_berita] = false;
                  ">
                    Simpan
                  </v-btn>
                </v-card-actions>
              </v-card>
            </v-dialog>
          </v-row>
        </VCardText>
      </VCard>
    </VCol>
  </VRow>
  <VRow>
    <VCol>
      <div class="text-center my-3 float-right">
        <v-pagination v-model="page" :length="banyakPage" :total-visible="5" @click="fetchData"></v-pagination>
      </div>
    </VCol>
  </VRow>
</template>

<script>
//import EditBerita from "./EditBerita.vue";
import axios from "axios";
import config from "@/@core/config.vue";
import { ref } from "vue";
import Swal from "sweetalert2";

export default {
  data() {
    return {
      dialog: ref([]),
      dataBerita: ref([]),
      urlServer: config.urlServer,
      refInput: ref(),
      page: 1,
      banyakPage: 0,
      isLoading: false,
    };
  },

  methods: {
    async putData(indexBerita) {
      try {
        const data = {
          id_berita: this.dataBerita[indexBerita].id_berita,
          judul: this.dataBerita[indexBerita].judul,
          tanggal_pelaksanaan: this.dataBerita[indexBerita].tanggal_pelaksanaan,
          deskripsi: this.dataBerita[indexBerita].deskripsi,
        };

        const response = await axios.put(`${this.urlServer}/api/berita`, data, {
          headers: {
            Authorization: localStorage.getItem("tokenAuth"),
          },
        });
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
        console.log(response);
      } catch (error) {
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
          title: "Judul dan Tanggal Pelaksanaan Tidak Boleh Kosong",
        });
      }
    },

    inputGambar() {
      document.getElementById("inputGambar").click();
    },

    async fetchData() {
      this.isLoading = true;

      const banyakDataTampil = 6;
      const response = await axios.get(
        `${this.urlServer}/api/berita?start=${this.page}&length=${banyakDataTampil}`
      );

      this.isLoading = false;

      this.dataBerita = response.data.berita.map((item) => {
        item.id_berita = ref(item.id_berita);
        item.judul = ref(item.judul);
        item.tanggal_pelaksanaan = ref(item.tanggal_pelaksanaan);
        item.deskripsi = ref(item.deskripsi);
        item.gambar = ref(config.imagePath + item.gambar);
        item.refInput = ref();
        return item;
      });
      this.banyakPage = Math.ceil(response.data.jumlah_data / banyakDataTampil);
    },

    async deleteBerita(id_berita) {
      const ask = await Swal.fire({
        title: "Anda yakin ingin menghapus?",
        showConfirmButton: false,
        showDenyButton: true,
        showCancelButton: true,
        denyButtonText: "Hapus",
      });
      if (ask.isDenied) {
        const response = await axios.delete(
          `${this.urlServer}/api/berita?id_berita=${id_berita}`,
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

    async changeAvatar(file, indexBerita) {
      const files = file.target.files[0];
      if (files) {
        const fileReader = new FileReader();
        // Validasi tipe file sebelum menampilkan gambarnya
        if (
          files.type === "image/jpeg" ||
          files.type === "image/png" ||
          files.type === "image/jpg"
        ) {
          fileReader.readAsDataURL(files);
          fileReader.onload = async () => {
            if (typeof fileReader.result === "string") {
              this.dataBerita[indexBerita].gambar = fileReader.result;
              const response = await axios.put(
                `${this.urlServer}/api/berita`,
                {
                  id_berita: this.dataBerita[indexBerita].id_berita,
                  gambar: fileReader.result,
                },
                {
                  headers: {
                    Authorization: localStorage.getItem("tokenAuth"),
                  },
                }
              );
            }
          };
        } else {
          // Tindakan jika tipe file tidak valid
          alert("File harus berupa gambar dengan tipe jpeg, png, atau jpg.");
          resetAvatar();
        }
      }
    },
  },

  mounted() {
    this.fetchData();
  },
};
</script>
