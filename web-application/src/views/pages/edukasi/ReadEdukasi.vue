<template>
  <VRow>
    <!-- 👉 Popular Uses Of The Internet -->
    <VCol v-for="data in dataEdukasi" cols="12" md="4" sm="12">
      <VCard>
        <VImg :src="urlServer + data.gambar" cover max-height="280" />

        <VCardItem>
          <VCardTitle>{{ data.judul }}</VCardTitle>
          <sup>{{ data.tanggal }}</sup>
        </VCardItem>

        <VCardText>
          <div class="mb-4">
            {{ data.materi }}
          </div>

          <v-row justify="center">
            <v-dialog v-model="dialog[data.id_edukasi]" persistent width="1024">
              <template v-slot:activator="{ props }">
                <VRow class="mt-3">
                  <VCol>
                    <VBtn> Lihat </VBtn>

                    <VBtn color="primary" class="mx-3" v-bind="props">
                      Edit
                    </VBtn>
                    <VBtn
                      color="error"
                      @click="deleteEdukasi(data.id_edukasi)"
                      class="float-right"
                    >
                      Hapus
                    </VBtn>
                  </VCol>
                </VRow>
              </template>
              <v-card>
                <v-card-title>
                  <span class="text-h5">Edit</span>
                </v-card-title>
                <v-card-text>
                  <v-container>
                    <v-row>
                      <v-col cols="12">
                        <v-text-field label="Judul" required></v-text-field>
                      </v-col>
                      <v-col cols="12">
                        <v-text-field label="Materi" required></v-text-field>
                      </v-col>
                      <VCol cols="12" md="9">
                        <div class="d-flex flex-column justify-center gap-5">
                          <div class="d-flex flex-wrap gap-2">
                            <VBtn color="primary" @click="refInputEl?.click()">
                              <VIcon icon="bx-cloud-upload" class="d-sm-none" />
                              <span class="d-none d-sm-block"
                                >Upload foto baru</span
                              >
                            </VBtn>

                            <input
                              ref="refInputEl"
                              type="file"
                              name="file"
                              accept=".jpeg,.png,.jpg"
                              hidden
                              @change="changeAvatar"
                            />

                            <VBtn
                              type="reset"
                              color="error"
                              variant="tonal"
                              @click="resetAvatar"
                            >
                              <span class="d-none d-sm-block">Reset</span>
                              <VIcon icon="bx-refresh" class="d-sm-none" />
                            </VBtn>
                          </div>
                        </div>
                        <VAvatar
                          rounded="lg"
                          size="200"
                          class="me-1 mt-3"
                          :image="projectImageLocal.imageValue"
                          v-show="projectImageLocal.imageValue !== ''"
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
                    @click="dialog[data.id_edukasi] = false"
                  >
                    Close
                  </v-btn>
                  <v-btn
                    color="blue-darken-1"
                    variant="text"
                    @click="dialog[data.id_edukasi] = false"
                  >
                    Save
                  </v-btn>
                </v-card-actions>
              </v-card>
            </v-dialog>
          </v-row>
        </VCardText>
      </VCard>
    </VCol>
  </VRow>
</template>

<script>
import images from "@images/pages/2.png";
import EditEdukasi from "./EditEdukasi.vue";
import axios from "axios";
import config from "@/@core/config.vue";
import { ref } from "vue";
export default {
  data() {
    const projectImage = {
      imageValue: "",
    };

    const projectImageLocal = ref({ ...projectImage });

    return {
      dialog: ref([]),
      refInputEl: ref(),
      dataEdukasi: [],
      urlServer: config.urlServer,
      projectImageLocal: projectImageLocal,
    };
  },

  methods: {
    async resetAvatar() {
      this.projectImageLocal.value.imageValue = projectImage.imageValue;
    },

    async fetchData() {
      const response = await axios.get(`${this.urlServer}/api/edukasi`);
      this.dataEdukasi = response.data;
    },

    async deleteEdukasi(id_edukasi) {
      const response = await axios.delete(
        `${this.urlServer}/api/edukasi?id_edukasi=${id_edukasi}`
      );
      if (response.data.success) {
        alert(response.data.success.message);
        this.fetchData();
      }
      console.log(response.data);
    },

    async changeAvatar(file) {
      const fileReader = new FieReader();
      const { files } = file.target;
      if (files && files.length) {
        // Validasi tipe file sebelum menampilkan gambarnya
        if (
          files[0].type === "image/jpeg" ||
          files[0].type === "image/png" ||
          files[0].type === "image/jpg"
        ) {
          fileReader.readAsDataURL(files[0]);
          fileReader.onload = () => {
            if (typeof fileReader.result === "string") {
              projectImageLocal.value.imageValue = fileReader.result;
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

  async mounted() {
    this.fetchData();
  },

  components: {
    EditEdukasi,
  },
};
</script>
