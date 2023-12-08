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
      posyanduImg: posyanduImg,
      posyandu: ref([]),
      langit: langit,
      profil: "Lorem ipsum dolor ",
      visi: "labore fugit assumenda ",
      misi: "corrupti veritatis quidem nostru",
    };
  },
  methods: {
    async putData() {
      try {
        const data = {
          nama_posyandu: this.posyandu.nama_posyandu,
          kota: this.posyandu.kota,
          kecamatan: this.posyandu.kecamatan,
          kelurahan: this.posyandu.kelurahan,
          rt_rw: this.posyandu.rt_rt,
          penyampaian_ketua: this.posyandu.penyampaian_ketua,
          gambar_gedung: this.posyandu.gambar_gedung,
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
        :src="langit"
        alt=""
      />
    </VCol>
    <VCol md="3" sm="12">
      <img
        style="width: 100%; height: 250px; object-fit: cover"
        :src="posyanduImg"
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
