<template>
  <VRow>
    <VCol cols="12" md="12">
      <VCol cols="12">
        <VCard>
          <VCardItem>
            <VueApexCharts type="line" height="450" :options="chartOptions" :series="series" />
          </VCardItem>
        </VCard>
      </VCol>
      <VCol cols="12">
        <VCard title="Data Penimbangan Bayi">
          <VCardText>
            <VRow>
              <VCol>
                <p class="mb-4">
                  Nama:
                  <font class="float-right">{{ dataEdit.bayi.nama }}</font>
                </p>
                <p class="mb-4">
                  Tanggal Lahir:
                  <font class="float-right">{{
                    dataEdit.bayi.tanggal_lahir
                  }}</font>
                </p>
                <p class="mb-4">
                  Jenis Kelamin:<font class="float-right">
                    {{ dataEdit.bayi.jenis_kelamin }}
                  </font>
                </p>
                <p class="mb-4">
                  BB Saat Lahir :<font class="float-right">
                    {{
                      dataEdit.bayi.berat_lahir
                      ? dataEdit.bayi.berat_lahir + " KG"
                      : "-"
                    }}
                  </font>
                </p>
              </VCol>
              <VCol cols="12" v-for="(item, index) in dataEdit.penimbangan">
                <h4 class="my-5">{{ item.judul }}</h4>
                <VRow>
                  <VCol cols="12" sm="3">
                    <VTextField v-model="dataEdit.penimbangan[index].berat_badan" type="number" label="Berat Badan"
                      placeholder="Masukkan Berat Badan" />
                  </VCol>
                  <VCol cols="12" sm="3">
                    <VTextField v-model="dataEdit.penimbangan[index].asi_eksklusif" label="Asi Ekskulusif"
                      placeholder="Masukkan " />
                  </VCol>
                  <VCol cols="12" sm="3">
                    <VTextField v-model="dataEdit.penimbangan[index].ntob" label="N/T/O/B & BGM" disabled />
                  </VCol>
                  <VCol cols="12" md="9" class="d-flex gap-4">
                    <VBtn :disabled="isLoading[index]" type="submit" :id="index" @click="
                      submitData(
                        dataEdit.penimbangan[index].berat_badan,
                        dataEdit.penimbangan[index].asi_eksklusif,
                        dataEdit.penimbangan[index].ntob,
                        dataEdit.penimbangan[index].judul,
                        index
                      )
                      ">
                      <VProgressCircular v-if="isLoading[index]" indeterminate color="white" :for="index">
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
import VueApexCharts from "vue3-apexcharts";
import axios from "axios";
import config from "@/@core/config.vue";
import Swal from "sweetalert2";
import { ref } from "vue";

export default {
  components: {
    VueApexCharts,
  },
  data() {
    return {
      isLoading: [],
      series: [
        {
          name: "Terlalu Gemuk, butuh penanganan",
          data: [
            5.0, 6.6, 8.0, 9.0, 9.7, 10.4
          ],
        },
        {
          name: "Berat Gemuk",
          data: [
            4.4, 5.8, 7.1, 8.0, 8.7, 9.3
          ],
        },
        {
          name: "Berat Normal, butuh penanganan",
          data: [
            2.9, 3.9, 4.9, 5.7, 6.2, 6.7
          ],
        },
        {
          name: "Berat Baik, butuh penanganan",
          data: [
            3.3, 4.5, 5.6, 6.4, 7.0, 7.5
          ],
        },
        {
          name: "Berat Normal, butuh penanganan",
          data: [
            3.9, 5.1, 6.3, 7.2, 7.8, 8.4
          ],
        },
        {
          name: "Berat Kurus",
          data: [
            2.5, 3.4, 4.3, 5.0, 5.6, 6.0
          ],
        },
        {
          name: "Terlalu Kurus, butuh penanganan",
          data: [
            2.1, 2.9, 3.8, 4.4, 4.9, 5.3
          ],
        },
      ],
      chartOptions: {
        chart: {
          height: 350,
          type: "line",
          toolbar: {
            show: false,
          },
        },
        colors: [
          "#FF5252", // rgb(var(--v-theme-error))
          "#FFC107", // rgb(var(--v-theme-warning))
          "#4CAF50", // rgb(var(--v-theme-success))
          "#4CAF50", // rgb(var(--v-theme-success))
          "#4CAF50", // rgb(var(--v-theme-success))
          "#FFC107", // rgb(var(--v-theme-warning))
          "#FF5252", // rgb(var(--v-theme-error))
        ],
        grid: {
          borderColor: "#e7e7e7",
          row: {
            colors: ["#f3f3f3", "transparent"], // takes an array which will be repeated on columns
            opacity: 0.5,
          },
        },
        markers: {
          size: 1,
        },
        xaxis: {
          categories: [
            "0",
            "1",
            "2",
            "3",
            "4",
            "5",
          ],
          title: {
            text: "Bulan",
          },
        },
        yaxis: {
          title: {
            text: "Berat Badan",
          },
          min: 0,
          max: 11,
        },
        legend: {
          position: "top",
          horizontalAlign: "right",
          floating: true,
          offsetY: -25,
          offsetX: -5,
        },
      },
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
        console.log(error);
      }
      this.isLoading[index] = false;
    },
  },
};
</script>
