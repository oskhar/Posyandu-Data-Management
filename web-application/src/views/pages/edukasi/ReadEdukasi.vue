<template>
  <VRow v-if="isUpload" style="
      position: fixed;
      z-index: 1;
      right: 50px;
      bottom: 50px;
      background-color: azure;
      padding: 1rem;
      padding-block: 5px;
      border-radius: 5px;
    ">
    <Font>Menyimpan... </Font>
    <VProgressCircular indeterminate color="primary" class="ml-3 float-center">
    </VProgressCircular>
  </VRow>
  <VRow v-if="isDelete" style="
      position: fixed;
      z-index: 1;
      right: 50px;
      bottom: 50px;
      background-color: azure;
      padding: 1rem;
      padding-block: 5px;
      border-radius: 5px;
    ">
    <Font>Menghapus... </Font>
    <VProgressCircular indeterminate color="primary" class="ml-3 float-center">
    </VProgressCircular>
  </VRow>
  <VRow>
    <VCol v-if="isLoading" cols="12" md="12" sm="12" class="text-center">
      <VProgressCircular indeterminate color="primary" class="mt-5" size="50"></VProgressCircular>
    </VCol>
    <VCol v-for="(data, index) in dataEdukasi" v-else cols="12" md="4" sm="12">
      <VCard>
        <VImg :src="data.gambar" cover style="height: 280px">
          <h2 v-if="data.gambar == imagePath + null" class="text-center text-secondary" style="margin-top: 25%">
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

          <VRow justify="center">
            <VDialog v-model="dialog[data.id_edukasi]" persistent width="1024">
              <template #activator="{ props }">
                <VRow class="mt-3">
                  <VCol>
                    <!-- <VBtn> Lihat </VBtn> -->

                    <VBtn color="primary" class="mx-3" v-bind="props">
                      Edit & Lihat
                    </VBtn>
                    <VBtn color="error" class="float-right" @click="deleteEdukasi(data.id_edukasi)">
                      <VIcon>bx-trash</VIcon>
                    </VBtn>
                  </VCol>
                </VRow>
              </template>
              <VCard>
                <VCardTitle>
                  <div class="text-h5">Edit</div>
                </VCardTitle>
                <VCardText>
                  <VContainer>
                    <!-- <p class="">Perubahan Otomatis Tersimpan</p> -->
                    <VRow>
                      <VCol cols="12">
                        <VTextField id="judul" v-model="data.judul" placeholder="Masukkan Judul"
                          persistent-placeholder />
                      </VCol>
                      <VCol cols="12">
                        <VTextarea id="materi" v-model="data.materi" placeholder="Masukkan Isi Materi"
                          persistent-placeholder />
                      </VCol>
                      <VCol cols="12">
                        <!-- <VImg :src="urlServer + data.gambar" :width="110" /> -->
                      </VCol>
                      <VCol cols="12" md="9">
                        <div class="d-flex flex-column justify-center gap-5">
                          <div class="d-flex flex-wrap gap-2">
                            <VBtn id="gambar" color="primary" @click="inputGambar">
                              <VIcon icon="bx-cloud-upload" class="d-sm-none" />
                              <span class="d-none d-sm-block">Upload foto baru</span>
                            </VBtn>

                            <input id="inputGambar" type="file" name="file" accept=".jpeg,.png,.jpg" hidden
                              @change="changeAvatar($event, index)" />
                          </div>
                        </div>
                        <VAvatar v-show="data.gambar !== ''" rounded="lg" size="200" class="me-1 mt-3"
                          :image="data.gambar" />
                      </VCol>
                    </VRow>
                  </VContainer>
                </VCardText>
                <VCardActions>
                  <VSpacer></VSpacer>
                  <VBtn color="blue-darken-1" variant="text" @click="dialog[data.id_edukasi] = false">
                    Tutup
                  </VBtn>
                  <VBtn color="blue-darken-1" variant="text" @click="
                    putData(index);
                  dialog[data.id_edukasi] = false;
                  ">
                    Simpan
                  </VBtn>
                </VCardActions>
              </VCard>
            </VDialog>
          </VRow>
        </VCardText>
      </VCard>
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
import axios from "axios";
import config from "@/@core/config";
import Swal from "sweetalert2";

export default {
  data() {
    return {
      dialog: [],
      dataEdukasi: [],
      urlServer: config.urlServer,
      imagePath: config.imagePath,
      page: 1,
      banyakPage: 0,
      isLoading: false,
      isUpload: false,
      isDelete: false,
    };
  },

  mounted() {
    this.fetchData();
  },

  methods: {
    async putData(indexEdukasi) {
      this.isUpload = true;
      try {
        const data = {
          id_edukasi: this.dataEdukasi[indexEdukasi].id_edukasi,
          judul: this.dataEdukasi[indexEdukasi].judul,
          materi: this.dataEdukasi[indexEdukasi].materi,
        };

        const response = await axios.put(
          `${this.urlServer}/api/edukasi`,
          data,
          {
            headers: {
              Authorization: localStorage.getItem("tokenAuth"),
            },
          },
        );

        this.isUpload = false;
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
          this.dataEdukasi[indexEdukasi].overview = data.materi;
        }
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
          title: "Judul Tidak Boleh Kosong atau Sama Seperti Yang Sudah Ada",
        });
      }
      this.isUpload = false;
    },

    inputGambar() {
      document.getElementById("inputGambar").click();
    },

    async fetchData() {
      this.isLoading = true;

      const banyakDataTampil = 6;

      const response = await axios.get(
        `${this.urlServer}/api/edukasi?start=${this.page}&length=${banyakDataTampil}`,
      );

      this.isLoading = false;

      this.dataEdukasi = response.data.edukasi.map(item => {
        item.gambar = this.imagePath + item.gambar;

        return item;
      });
      this.banyakPage = Math.ceil(response.data.jumlah_data / banyakDataTampil);
    },

    async deleteEdukasi(id_edukasi) {
      const ask = await Swal.fire({
        title: "Anda yakin ingin menghapus?",
        showConfirmButton: false,
        showDenyButton: true,
        showCancelButton: true,
        denyButtonText: "Hapus",
      });

      if (ask.isDenied) {
        this.isDelete = true;

        const response = await axios.delete(
          `${this.urlServer}/api/edukasi?id_edukasi=${id_edukasi}`,
          {
            headers: {
              Authorization: localStorage.getItem("tokenAuth"),
            },
          },
        );

        this.isDelete = false;
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

    async changeAvatar(file, indexEdukasi) {
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
              this.dataEdukasi[indexEdukasi].gambar = fileReader.result;

              const response = await axios.put(
                `${this.urlServer}/api/edukasi`,
                {
                  id_edukasi: this.dataEdukasi[indexEdukasi].id_edukasi,
                  gambar: fileReader.result,
                },
                {
                  headers: {
                    Authorization: localStorage.getItem("tokenAuth"),
                  },
                },
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
};
</script>
