<script>
// 👉 Images
import posyanduImg from "@images/pages/3.png";
import langit from "@images/pages/2.png";
import config from "@/@core/config.vue";
import axios from "axios";
import Swal from "sweetalert2";
import { ref } from "vue";

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
    };
  },
  methods: {
    inputGambar() {
      // console.log(this.posyandu.refInput);
      document.getElementById("inputGambar").click();
    },
    async changeAvatar(file) {
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
    async putData() {
      try {
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
        console.log(data);

        const response = await axios.put(
          `${config.urlServer}/api/posyandu`,
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
      const response = await axios.get(`${config.urlServer}/api/posyandu`, {
        headers: {
          Authorization: localStorage.getItem("tokenAuth"),
        },
      });
      this.posyandu = response.data;
      this.posyandu.gambar_gedung =
        config.imagePath + this.posyandu.gambar_gedung;
    },
  },
  mounted() {
    this.fetchData();
  },
};
</script>

<template>
  <VRow>
    <div class="d-flex w-100 align-content-center">
      <VRow class="mx-1">
        <VCol cols="12">
          <v-row justify="center">
            <v-dialog v-model="dialog" persistent width="1024">
              <template v-slot:activator="{ props }">
                <div style="width: 100%" class="py-5 px-3">
                  <h1 class="text-primary float-left">POSYANDU MELATI</h1>
                  <v-btn color="primary" class="float-right" v-bind="props">
                    Edit
                  </v-btn>
                </div>
              </template>
              <v-card>
                <v-card-title>
                  <span class="text-h5">User Profile</span>
                </v-card-title>
                <v-card-text>
                  <v-container>
                    <v-row>
                      <v-col cols="12">
                        <VTextarea
                          label="Profil"
                          v-model="posyandu.penyampaian_ketua"
                          required
                        ></VTextarea>
                      </v-col>
                      <v-col cols="12">
                        <VTextarea
                          label="Visi"
                          v-model="posyandu.visi"
                          required
                        ></VTextarea>
                      </v-col>
                      <v-col cols="12">
                        <VTextarea
                          label="Misi"
                          v-model="posyandu.misi"
                          required
                        ></VTextarea>
                      </v-col>
                      <VCol cols="12" md="9">
                        <div class="d-flex flex-column justify-center gap-5">
                          <div class="d-flex flex-wrap gap-2">
                            <VBtn
                              id="gambar"
                              color="primary"
                              @click="inputGambar"
                            >
                              <VIcon icon="bx-cloud-upload" class="d-sm-none" />
                              <span class="d-none d-sm-block"
                                >Upload foto baru</span
                              >
                            </VBtn>

                            <input
                              id="inputGambar"
                              type="file"
                              name="file"
                              accept=".jpeg,.png,.jpg"
                              hidden
                              @change="changeAvatar($event)"
                            />
                          </div>
                        </div>
                        <VAvatar
                          rounded="lg"
                          size="200"
                          class="me-1 mt-3"
                          :image="posyandu.gambar_gedung"
                        />
                      </VCol>
                    </v-row>
                  </v-container>
                </v-card-text>
                <v-card-actions>
                  <v-spacer></v-spacer>
                  <v-btn
                    color="blue-darken-1"
                    variant="text"
                    @click="dialog = false"
                  >
                    Close
                  </v-btn>
                  <v-btn
                    color="blue-darken-1"
                    variant="text"
                    @click="
                      putData();
                      dialog = false;
                    "
                  >
                    Save
                  </v-btn>
                </v-card-actions>
              </v-card>
            </v-dialog>
          </v-row>
        </VCol>
      </VRow>
    </div>
    <VCol cols="12">
      <img
        style="width: 100%; height: 500px; object-fit: cover"
        :src="posyandu.gambar_gedung"
        alt=""
      />
    </VCol>
    <VCol md="3" sm="12">
      <img
        style="width: 100%; height: 250px; object-fit: cover"
        :src="imagePath + posyandu.foto_profile_ketua"
        alt=""
      />
    </VCol>
    <VCol md="9" sm="12">
      <VCard class="text-center text-sm-start">
        <VRow no-gutters>
          <VCol cols="12">
            <VCardItem>
              <VCardTitle class="text-md-h5 text-primary">
                PROFIL POSYANDU
              </VCardTitle>
            </VCardItem>

            <VCardText>
              <span>
                {{ posyandu.penyampaian_ketua }}
              </span>
              <br />
            </VCardText>
          </VCol>
        </VRow>
      </VCard>
    </VCol>
    <VCol cols="12">
      <VCard class="text-center text-sm-start">
        <VRow no-gutters>
          <VCol cols="12">
            <VCardItem>
              <VCardTitle class="text-md-h5 text-primary"> VISI </VCardTitle>
            </VCardItem>

            <VCardText>
              <span>
                {{ posyandu.visi }}
              </span>
              <br />
            </VCardText>
          </VCol>
        </VRow>
      </VCard>
    </VCol>
    <VCol cols="12">
      <VCard class="text-center text-sm-start">
        <VRow no-gutters>
          <VCol cols="12">
            <VCardItem>
              <VCardTitle class="text-md-h5 text-primary"> MISI </VCardTitle>
            </VCardItem>

            <VCardText>
              <span>
                {{ posyandu.misi }}
              </span>
              <br />
            </VCardText>
          </VCol>
        </VRow>
      </VCard>
    </VCol>
  </VRow>
</template>
