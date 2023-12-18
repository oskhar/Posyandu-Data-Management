<template>
  <div class="text-center" style="margin-top: 200px">
    <h1 class="text-black">EDUKASI</h1>
  </div>

  <V-row class="mt-5">
    <VCol v-for="(data, index) in dataEdukasi" cols="3" md="4" sm="3">
      <RouterLink to="./edukasi-guest">
        <VCard>
          <VImg :src="data.gambar" cover style="height: 200px">
            <h2
              v-if="data.gambar == urlServer + null"
              class="text-center text-secondary"
              style="margin-top: 25%"
            >
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
              <v-dialog
                v-model="dialog[data.id_edukasi]"
                persistent
                width="1024"
              >
                <!-- <template v-slot:activator="{ props }">
                  <VRow class="mt-3">
                    <VCol>
                      <VBtn color="primary" class="mx-3" v-bind="props">
                        Selengkapnya
                      </VBtn>
                    </VCol>
                  </VRow>
                </template> -->
              </v-dialog>
            </v-row>
          </VCardText>
        </VCard>
      </RouterLink>
    </VCol>
  </V-row>

  <VRow>
    <VCol>
      <div class="text-center my-3 float-right">
        <v-pagination
          v-model="page"
          :length="banyakPage"
          :total-visible="5"
          @click="fetchData"
        ></v-pagination>
      </div>
    </VCol>
  </VRow>
</template>

<script>
//import EditEdukasi from "./EditEdukasi.vue";
import axios from "axios";
import config from "@/@core/config.vue";
import { ref } from "vue";
import Swal from "sweetalert2";

export default {
  data() {
    return {
      dialog: ref([]),
      dataEdukasi: ref([]),
      urlServer: config.urlServer,
      refInput: ref(),
      page: 1,
      banyakPage: 0,
    };
  },

  methods: {
    async putData(indexEdukasi) {
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

    inputGambar() {
      document.getElementById("inputGambar").click();
    },

    async fetchData() {
      const banyakDataTampil = 3;
      const response = await axios.get(
        `${this.urlServer}/api/edukasi?start=${this.page}&length=${banyakDataTampil}`
      );
      this.dataEdukasi = response.data.edukasi.map((item) => {
        item.id_edukasi = ref(item.id_edukasi);
        item.judul = ref(item.judul);
        item.materi = ref(item.materi);
        item.gambar = ref(this.urlServer + item.gambar);
        item.refInput = ref();
        return item;
      });
      this.banyakPage = Math.ceil(response.data.jumlah_data / banyakDataTampil);
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

<style scope>
.card-tiga {
  display: flex;
  justify-content: space-between;
  margin-top: 50px;
}
</style>
