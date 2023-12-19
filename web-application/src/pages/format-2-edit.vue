<template>
  <VRow>
    <VCol cols="12" md="12">
      <VCol cols="12">
        <VCard>
          <VCardItem>
            <h4 class="mb-4">
              Nama: <font class="float-right">{{ dataEdit.bayi.nama }}</font>
            </h4>
            <h4 class="mb-4">
              Tanggal Lahir:
              <font class="float-right">{{ dataEdit.bayi.tanggal_lahir }}</font>
            </h4>
            <h4 class="mb-4">
              Jenis Kelamin:<font class="float-right">
                {{ dataEdit.bayi.jenis_kelamin }}
              </font>
            </h4>
            <h4 class="mb-4">
              BB Saat Lahir :<font class="float-right">
                {{
                  dataEdit.bayi.berat_lahir
                    ? dataEdit.bayi.berat_lahir + " KG"
                    : "-"
                }}
              </font>
            </h4>
          </VCardItem>
        </VCard>
      </VCol>
      <VCol cols="12">
        <VCard title="Tambah Data Bayi">
          <VCardText>
            <VRow>
              <VCol cols="12" v-for="(item, index) in dataEdit.penimbangan">
                <h4 class="my-5">{{ item.judul }}</h4>
                <VRow>
                  <VCol cols="12" sm="3">
                    <VTextField
                      v-model="dataEdit.penimbangan[index].berat_badan"
                      label="Berat Badan"
                      placeholder="Masukkan Berat Badan"
                    />
                  </VCol>
                  <VCol cols="12" sm="3">
                    <VTextField
                      v-model="dataEdit.penimbangan[index].asi_eksklusif"
                      label="Asi Ekskulusif"
                      placeholder="Masukkan "
                    />
                  </VCol>
                  <VCol cols="12" sm="3">
                    <VTextField
                      v-model="dataEdit.penimbangan[index].ntob"
                      label="N/T/O/B & BGM"
                      disabled
                    />
                  </VCol>
                  <VCol cols="12" md="9" class="d-flex gap-4">
                    <VBtn
                      :disabled="isLoading[index]"
                      type="submit"
                      :id="index"
                      @click="
                        submitData(
                          dataEdit.penimbangan[index].berat_badan,
                          dataEdit.penimbangan[index].asi_eksklusif,
                          dataEdit.penimbangan[index].ntob,
                          dataEdit.penimbangan[index].judul,
                          index
                        )
                      "
                    >
                      <VProgressCircular
                        v-if="isLoading[index]"
                        indeterminate
                        color="white"
                        :for="index"
                      >
                      </VProgressCircular>

                      <font v-else>Submit</font>
                    </VBtn>
                  </VCol>
                </VRow>
              </VCol>
            </VRow>
          </VCardText>
        </VCard>
      </VCol>
    </VCol>
  </VRow>
</template>

<script>
import axios from "axios";
import config from "@/@core/config.vue";
import Swal from "sweetalert2";
import { ref } from "vue";

export default {
  data() {
    return {
      isLoading: [],
      dataEdit: {
        bayi: {
          nama: "",
          tanggal_lahir: "",
          jenis_kelamin: "",
          berat_lahir: null,
          keterangan: null,
        },
        penimbangan: [],
      },
    };
  },
  mounted() {
    this.fetchData();
  },
  methods: {
    async fetchData() {
      // Membuat objek URLSearchParams dari query string
      const queryString = window.location.search;
      const queryParams = new URLSearchParams(queryString);

      // Mendapatkan nilai dari parameter tertentu
      if (queryParams.get("id_bayi")) {
        const idBayi = queryParams.get("id_bayi");
        const response = await axios.get(
          `${config.urlServer}/api/format-ba?id_bayi=${idBayi}`,
          {
            headers: {
              Authorization: localStorage.getItem("tokenAuth"),
            },
          }
        );
        console.log(idBayi);
        this.dataEdit = response.data;
        for (let i = 0; i < this.dataEdit.length; i++) {
          this.isLoading[i] = false;
        }
        console.log(this.dataEdit);
      } else {
        window.location.href = "/dashboard";
      }
    },
    async submitData(berat_badan, asi_eksklusif, ntob, judul, index) {
      this.isLoading[index] = true;
      try {
        const queryString = window.location.search;
        const queryParams = new URLSearchParams(queryString);
        const idBayi = queryParams.get("id_bayi");
        const data = {
          berat_badan: berat_badan,
          asi_eksklusif: asi_eksklusif,
          ntob: ntob,
          judul: judul,
          id_bayi: idBayi,
        };
        console.log(data);
        const response = await axios.post(
          `${config.urlServer}/api/format-ba`,
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
          title: "Format Salah",
        });
      }
      this.isLoading[index] = false;
    },
  },
};
</script>
