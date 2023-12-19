<template>
  <VRow>
    <VCol cols="12" md="12">
      <VCol cols="12">
        <VCard>
          <VCardItem>
            <VueApexCharts
              type="line"
              height="350"
              :options="chartOptions"
              :series="series"
            />
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
            5.0, 6.6, 8.0, 9.0, 9.7, 10.4, 10.9, 11.4, 11.9, 12.3, 12.7, 13.0,
            13.3, 13.7, 14.0, 14.3, 14.6, 14.9, 15.3, 15.6, 15.9, 16.2, 16.5,
            16.8, 17.1, 17.5, 17.8, 18.1, 18.4, 18.7, 19.0, 19.3, 19.6, 19.9,
            20.2, 20.4, 20.7, 21.0, 21.3, 21.6, 21.9, 22.1, 22.4, 22.7, 23.0,
            23.3, 23.6, 23.9, 24.2,
          ],
        },
        {
          name: "Berat Gemuk",
          data: [
            4.4, 5.8, 7.1, 8.0, 8.7, 9.3, 9.8, 10.3, 10.7, 11.0, 11.4, 11.7,
            12.0, 12.3, 12.6, 12.8, 13.1, 13.4, 13.7, 13.9, 14.2, 14.5, 14.7,
            15.0, 15.3, 15.5, 15.8, 16.1, 16.3, 16.6, 16.9, 17.1, 17.4, 17.6,
            17.8, 18.1, 18.3, 18.6, 18.8, 19.0, 19.3, 19.5, 19.7, 20.0, 20.2,
            20.5, 20.7, 20.9, 21.2,
          ],
        },
        {
          name: "Berat Normal, butuh penanganan",
          data: [
            2.9, 3.9, 4.9, 5.7, 6.2, 6.7, 7.1, 7.4, 7.7, 8.0, 8.2, 8.4, 8.6,
            8.8, 9.0, 9.2, 9.4, 9.6, 9.8, 10.0, 10.1, 10.3, 10.5, 10.7, 10.8,
            11.0, 11.2, 11.3, 11.5, 11.7, 11.8, 12.0, 12.1, 12.3, 12.4, 12.6,
            12.7, 12.9, 13.0, 13.1, 13.3, 13.4, 13.6, 13.7, 13.8, 14.0, 14.1,
            14.3, 14.4,
          ],
        },
        {
          name: "Berat Baik, butuh penanganan",
          data: [
            3.3, 4.5, 5.6, 6.4, 7.0, 7.5, 7.9, 8.3, 8.6, 8.9, 9.2, 9.4, 9.6,
            9.9, 10.1, 10.3, 10.5, 10.7, 10.9, 11.1, 11.3, 11.5, 11.8, 12.0,
            12.2, 12.4, 12.5, 12.7, 12.9, 13.1, 13.3, 13.5, 13.7, 13.8, 14.0,
            14.2, 14.3, 14.5, 14.7, 14.8, 15.0, 15.2, 15.3, 15.5, 15.7, 15.8,
            16.0, 16.2, 16.3,
          ],
        },
        {
          name: "Berat Normal, butuh penanganan",
          data: [
            3.9, 5.1, 6.3, 7.2, 7.8, 8.4, 8.8, 9.2, 9.6, 9.9, 10.2, 10.5, 10.8,
            11.0, 11.3, 11.5, 11.7, 12.0, 12.2, 12.5, 12.7, 12.9, 13.2, 13.4,
            13.6, 13.9, 14.1, 14.3, 14.5, 14.8, 15.0, 15.2, 15.4, 15.6, 15.8,
            16.0, 16.2, 16.4, 16.6, 16.8, 17.0, 17.2, 17.4, 17.6, 17.8, 18.0,
            18.2, 18.4, 18.6,
          ],
        },
        {
          name: "Berat Kurus",
          data: [
            2.5, 3.4, 4.3, 5.0, 5.6, 6.0, 6.4, 6.7, 6.9, 7.1, 7.4, 7.6, 7.7,
            7.9, 8.1, 8.3, 8.4, 8.6, 8.8, 8.9, 9.1, 9.2, 9.4, 9.5, 9.7, 9.8,
            10.0, 10.1, 10.2, 10.4, 10.5, 10.7, 10.8, 10.9, 11.0, 11.2, 11.3,
            11.4, 11.5, 11.6, 11.8, 11.9, 12.0, 12.1, 12.2, 12.4, 12.5, 12.6,
            12.7,
          ],
        },
        {
          name: "Terlalu Kurus, butuh penanganan",
          data: [
            2.1, 2.9, 3.8, 4.4, 4.9, 5.3, 5.7, 5.9, 6.2, 6.4, 6.6, 6.8, 6.9,
            7.1, 7.2, 7.4, 7.5, 7.7, 7.8, 8.0, 8.1, 8.2, 8.4, 8.5, 8.6, 8.8,
            8.9, 9.0, 9.1, 9.2, 9.4, 9.5, 9.6, 9.7, 9.8, 9.9, 10.0, 10.1, 10.2,
            10.3, 10.4, 10.5, 10.6, 10.7, 10.8, 10.9, 11.0, 11.1, 11.2,
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
            "6",
            "7",
            "8",
            "9",
            "10",
            "11",
            "12",
            "13",
            "14",
            "15",
            "16",
            "17",
            "18",
            "19",
            "20",
            "21",
            "22",
            "23",
            "24",
            "25",
            "26",
            "27",
            "28",
            "29",
            "30",
            "31",
            "32",
            "33",
            "34",
            "35",
            "36",
            "37",
            "38",
            "39",
            "40",
            "41",
            "42",
            "43",
            "44",
            "45",
            "46",
            "47",
            "48",
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
          max: 30,
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
      }
      this.isLoading[index] = false;
    },
  },
};
</script>
