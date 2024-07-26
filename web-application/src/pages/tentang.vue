<script>
import posyanduImg from "@images/pages/3.png";
import langit from "@images/pages/2.png";
import config from "@/@core/config";
import axios from "axios";
import Swal from "sweetalert2";
import { ref } from "vue";
import { getFullImagePath } from "@/utils/get-full-image-path";

export default {
  data() {
    return {
      dialog: false,
      urlServer: config.urlServer,
      refInput: ref(),
      imagePath: config.imagePath,
      posyanduImg: posyanduImg,
      posyandu: ref([]),
      langit: langit,
      isUpload: false,
      isLoading: false,
    };
  },
  mounted() {
    this.fetchData();
  },
  methods: {
    getFullImagePath,
    inputGambar() {
      document.getElementById("inputGambar").click();
    },
    inputGambarStruktur() {
      document.getElementById("inputGambarStruktur").click();
    },
    async changeGambarCover(file) {
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
              this.posyandu.gambar_gedung = fileReader.result;

              const response = await axios.put(
                `${this.urlServer}/api/posyandu`,
                {
                  gambar_gedung: this.posyandu.gambar_gedung,
                },
                {
                  headers: {
                    Authorization: localStorage.getItem("tokenAuth"),
                  },
                },
              );

              this.fetchData();

            }
          };
        } else {
          // Tindakan jika tipe file tidak valid
          alert("File harus berupa gambar dengan tipe jpeg, png, atau jpg.");
          resetAvatar();
        }
      }


    },
    async changeGambarStruktur(file) {
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
              this.posyandu.gambar_struktur_organisasi = fileReader.result;

              const response = await axios.put(
                `${this.urlServer}/api/posyandu`,
                {
                  gambar_struktur_organisasi: this.posyandu.gambar_struktur_organisasi,
                },
                {
                  headers: {
                    Authorization: localStorage.getItem("tokenAuth"),
                  },
                },
              );

              this.fetchData();
            }
          };
        } else {
          // Tindakan jika tipe file tidak valid
          alert("File harus berupa gambar dengan tipe jpeg, png, atau jpg.");
          resetAvatar();
        }
      }
    },
    async putData() {
      try {
        this.isUpload = true;

        const data = {
          nama_posyandu: this.posyandu.nama_posyandu,
          kota: this.posyandu.kota,
          kecamatan: this.posyandu.kecamatan,
          kelurahan: this.posyandu.kelurahan,
          rt_rw: this.posyandu.rt_rt,
          penyampaian_ketua: this.posyandu.penyampaian_ketua,
          visi: this.posyandu.visi,
          misi: this.posyandu.misi,
        };

        const response = await axios.put(
          `${config.urlServer}/api/posyandu`,
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

          this.fetchData();
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
          timer: 1500,
          icon: "error",
          title: error.response.data.error.message,
        });
      }
    },
    async fetchData() {
      this.isLoading = true;

      const response = await axios.get(`${config.urlServer}/api/posyandu`, {
        headers: {
          Authorization: localStorage.getItem("tokenAuth"),
        },
      });

      this.posyandu = response.data;
      this.isLoading = false;
    },
  },
};
</script>

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
  <VRow v-if="isLoading" cols="12" md="12" sm="12" class="text-center">
    <VCol>
      <VProgressCircular indeterminate color="primary" class="mt-5" size="50">
      </VProgressCircular>
    </VCol>
  </VRow>
  <VRow v-else>
    <div class="d-flex w-100 align-content-center">
      <VRow class="mx-1">
        <VCol cols="12">
          <VRow justify="center">
            <VDialog v-model="dialog" persistent width="1024">
              <template #activator="{ props }">
                <div style="width: 100%" class="py-5 px-3">
                  <h1 class="text-primary float-left">Halaman Edit Tentang Posyandu Melati</h1>
                  <VBtn color="primary" class="float-right" v-bind="props" prepend-icon="bx-pencil">Edit</VBtn>
                </div>
              </template>
              <VCard>
                <VCardTitle>
                  <span class="text-h5">Edit Halaman</span>
                </VCardTitle>
                <VCardText>
                  <VContainer>
                    <VRow>
                      <VCol cols="12">
                        <VTextarea v-model="posyandu.penyampaian_ketua" label="Profil" required></VTextarea>
                      </VCol>
                      <VCol cols="12">
                        <VTextarea v-model="posyandu.visi" label="Visi" required></VTextarea>
                      </VCol>
                      <VCol cols="12">
                        <VTextarea v-model="posyandu.misi" label="Misi" required></VTextarea>
                      </VCol>
                      <VCol cols="12">
                        <div class="d-flex justify-center gap-5">
                          <div class="d-flex justify-center flex-column align-center gap-2">
                            <VBtn id="gambar" color="primary" @click="inputGambar">
                              <VIcon icon="bx-cloud-upload" class="d-sm-none" />
                              <span class="d-none d-sm-block">Upload foto cover baru</span>
                            </VBtn>

                            <input id="inputGambar" type="file" name="file" accept=".jpeg,.png,.jpg" hidden
                              @change="changeGambarCover($event)" />
                            <VAvatar rounded="lg" size="200" class="me-1 mt-3"
                              :image="getFullImagePath(posyandu.gambar_gedung)" />
                          </div>
                          <div class="d-flex justify-center flex-column align-center gap-2">
                            <VBtn id="gambar" color="primary" @click="inputGambarStruktur">
                              <VIcon icon="bx-cloud-upload" class="d-sm-none" />
                              <span class="d-none d-sm-block">Upload foto struktur organisasi</span>
                            </VBtn>

                            <input id="inputGambarStruktur" type="file" name="file" accept=".jpeg,.png,.jpg" hidden
                              @change="changeGambarStruktur($event)" />
                            <VAvatar rounded="lg" size="200" class="me-1 mt-3"
                              :image="getFullImagePath(posyandu.gambar_struktur_organisasi)" />
                          </div>
                        </div>
                      </VCol>
                    </VRow>
                  </VContainer>
                </VCardText>
                <VCardActions>
                  <VSpacer></VSpacer>
                  <VBtn color="blue-darken-1" variant="text" @click="dialog = false">
                    Tutup
                  </VBtn>
                  <VBtn color="blue-darken-1" variant="text" @click="
                    putData();
                  dialog = false;
                  ">
                    Simpan
                  </VBtn>
                </VCardActions>
              </VCard>
            </VDialog>
          </VRow>
        </VCol>
      </VRow>
    </div>
    <VCol cols="12">
      <VCard>
        <VCardText>
          <h2 class="text-md-h5 font-weight-bold text-primary mb-4">Gambar Cover Halaman Tentang</h2>
          <img style="width: 100%; height: 500px; object-fit: cover" class="rounded"
            :src="getFullImagePath(posyandu.gambar_gedung)" alt="" />
        </VCardText>
      </VCard>
    </VCol>
    <VCol cols="12">
      <VCard>
        <VCardText>
          <h2 class="text-md-h5 font-weight-bold text-primary mb-4">Gambar Struktur Organisasi</h2>
          <img style="width: 100%; height: 500px; object-fit: cover" class="rounded"
            :src="getFullImagePath(posyandu.gambar_struktur_organisasi)" alt="" />
        </VCardText>
      </VCard>
    </VCol>
    <VCol cols="12">
      <VCard class="text-center text-sm-start">
        <VCardText>
          <VRow>
            <VCol cols="12" md="3">
              <img style="width: 100%; object-fit: cover" class="rounded"
                :src="getFullImagePath(posyandu.foto_profile_ketua)" alt="" />
            </VCol>

            <VCol cols="12" md="9" class="d-flex flex-column justify-center">
              <h2 class="text-md-h5 font-weight-bold text-primary mb-2">
                Penyampaian Ketua
              </h2>

              <p class='text-subtitle-1 mb-0' style="white-space: pre-line;">
                {{ posyandu.penyampaian_ketua }}
              </p>
            </VCol>
          </VRow>
        </VCardText>
      </VCard>
    </VCol>
    <VCol cols="12">
      <VCard class="text-center text-sm-start">
        <VCardText>
          <VRow>
            <VCol cols="12">
              <h2 class="text-md-h5 font-weight-bold text-primary mb-2">
                Visi Kami
              </h2>

              <p class='text-subtitle-1 mb-0' style="white-space: pre-line;">
                {{ posyandu.visi }}
              </p>
            </VCol>
          </VRow>
        </VCardText>
      </VCard>
    </VCol>
    <VCol cols="12">
      <VCard class="text-center text-sm-start">
        <VCardText>
          <VRow>
            <VCol cols="12">
              <h2 class="text-md-h5 font-weight-bold text-primary mb-2">
                Misi Kami
              </h2>

              <p class='text-subtitle-1 mb-0' style="white-space: pre-line;">
                {{ posyandu.misi }}
              </p>
            </VCol>
          </VRow>
        </VCardText>
      </VCard>
    </VCol>
  </VRow>
</template>
