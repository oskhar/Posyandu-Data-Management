<template>
  <VRow>
    <!-- 👉 Popular Uses Of The Internet -->
    <VCol v-for="(data, index) in dataEdukasi" cols="12" md="4" sm="12">
      <VCard>
        <VImg :src="data.gambar" cover max-height="280" />

        <VCardItem>
          <VCardTitle>{{ data.judul }}</VCardTitle>
          <sup>{{ data.tanggal }}</sup>
        </VCardItem>

        <VCardText>
          <p class="mb-4">
            {{ data.materi }}
          </p>

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
                  <div class="text-h5">Edit</div>
                </v-card-title>
                <v-card-text>
                  <v-container>
                    <!-- <p class="">Perubahan Otomatis Tersimpan</p> -->
                    <v-row>
                      <v-col cols="12">
                        <VTextField
                          id="judul"
                          v-model="data.judul"
                          placeholder="Masukkan Judul"
                          persistent-placeholder
                        />
                      </v-col>
                      <v-col cols="12">
                        <VTextarea
                          id="materi"
                          v-model="data.materi"
                          placeholder="Masukkan Isi Materi"
                          persistent-placeholder
                        />
                      </v-col>
                      <v-col cols="12">
                        <!-- <VImg :src="urlServer + data.gambar" :width="110" /> -->
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
                              :ref="data.refInput"
                              type="file"
                              name="file"
                              accept=".jpeg,.png,.jpg"
                              hidden
                              @change="changeAvatar($event, index)"
                            />
                          </div>
                        </div>
                        <VAvatar
                          rounded="lg"
                          size="200"
                          class="me-1 mt-3"
                          :image="data.gambar"
                          v-show="data.gambar !== ''"
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
                    Tutup
                  </v-btn>
                  <v-btn
                    color="blue-darken-1"
                    variant="text"
                    @click="
                      putData(index);
                      dialog[data.id_edukasi] = false;
                    "
                  >
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
</template>

<script>
//import EditEdukasi from "./EditEdukasi.vue";
import axios from "axios";
import config from "@/@core/config.vue";
import { ref } from "vue";
export default {
  data() {
    return {
      dialog: ref([]),
      dataEdukasi: ref([]),
      urlServer: config.urlServer,
      refInput: ref(),
    };
  },

  methods: {
    async putData(indexEdukasi) {
      try {
        // data.append(
        //   "id_edukasi",
        //   this.dataEdukasi[indexEdukasi].id_edukasi.value
        // );
        // data.append("judul", this.dataEdukasi[indexEdukasi].judul.value);
        // data.append("materi", this.dataEdukasi[indexEdukasi].materi.value);
        // data.append("gambar", this.dataEdukasi[indexEdukasi].gambar.value);
        // const response = await axios.post(
        //   `${this.urlServer}/api/edukasi`,
        //   data
        // );
        // console.log(this.dataEdukasi);
        const data = {
          id_edukasi: this.dataEdukasi[indexEdukasi].id_edukasi,
          judul: this.dataEdukasi[indexEdukasi].judul,
          materi: this.dataEdukasi[indexEdukasi].materi,
          gambar: this.dataEdukasi[indexEdukasi].gambar,
        };
        console.log(data);

        const response = await axios.put(
          `${this.urlServer}/api/edukasi`,
          data,
          {
            headers: {
              "Content-Type": "application/json",
            },
          }
        );
        console.log(response);
      } catch (error) {
        console.log(error);
      }
      // const data = new FormData();
      // data.append("id_admin", 1);
      // data.append("judul", edukasi.judul);
      // data.append("materi", edukasi.materi);
      // // data.append("gambar", this.dataEdukasi.gambar);
      // const response = await axios.post(
      //   `${this.urlServer}/api/edukasi`,
      //   data
      // );

      //   const { data } = await axios.put(`${this.urlServer}/api/edukasi`, {
      //     id_edukasi: dataEdukasi.id_edukasi,
      //     judul: dataEdukasi.judul,
      //     materi: dataEdukasi.materi,
      //   });
      //   console.log(dataEdukasi.materi);
      // } catch (error) {
      //   console.log(error);
      // }
    },

    inputGambar() {
      document.getElementById("inputGambar").click();
    },

    async fetchData() {
      const response = await axios.get(`${this.urlServer}/api/edukasi`);
      this.dataEdukasi = response.data.map((item) => {
        item.id_edukasi = ref(item.id_edukasi);
        item.judul = ref(item.judul);
        item.materi = ref(item.materi);
        item.gambar = ref(this.urlServer + item.gambar);
        item.refInput = ref();
        return item;
      });
      console.log(this.dataEdukasi);
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
          fileReader.onload = () => {
            if (typeof fileReader.result === "string") {
              this.dataEdukasi[indexEdukasi].gambar = fileReader.result;
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
