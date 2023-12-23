<template>
  <VRow>
    <VCol cols="12" md="12">
      <VCol cols="12">
        <VCard>
          <VCardItem>
            <VueApexCharts type="line" height="530" :options="chartOptions" :series="series" />
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
                  Nama Ayah:
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
                  <VCol cols="12" sm="6" md="3">
                    <VTextField v-model="dataEdit.penimbangan[index].berat_badan" type="number" label="Berat Badan"
                      placeholder="Masukkan Berat Badan" />
                  </VCol>
                  <VCol v-if="index < 23" cols="12" sm="6" md="3">
                    <VSelect v-model="dataEdit.penimbangan[index].asi_eksklusif" label="Asi Eksklusif"
                      placeholder="Masukkan Asi Ekslusif" :items="['Ya', 'Tidak', 'Alpa']" />
                  </VCol>
                  <VCol cols="12" sm="12" md="6">
                    <VBtn class="text-none text-subtitle-1" color="black">{{ dataEdit.penimbangan[index].ntob }}</VBtn>
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

                      <font v-else>
                        simpan
                      </font>
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

export default {
  components: {
    VueApexCharts,
  },
  data() {
    return {
      isLoading: [],
      series: [],
      chartOptions: {
        chart: {
          height: 350,
          type: "line",
          zoom: {
            enabled: false
          },
        },
        toolBar: {
          tools: {
            download: '<img src="/static/icons/download.png" class="ico-download" width="20">',
          }
        },
        colors: [
          "#FF5252", // rgb(var(--v-theme-error))
          "#FFC107", // rgb(var(--v-theme-warning))
          "#4CAF50", // rgb(var(--v-theme-success))
          "#4CAF50", // rgb(var(--v-theme-success))
          "#4CAF50", // rgb(var(--v-theme-success))
          "#FFC107", // rgb(var(--v-theme-warning))
          "#FF5252", // rgb(var(--v-theme-error))
          "#696CFF",
        ],
        markers: {
          size: 1,
        },
        xaxis: {
          title: {
            text: "Umur Bayi (bulan)",
          },
          categories: this.categories,
          labels: {
            formatter: (value) => {
              return `${value - 1}`
            },
          }
        },
        markers: {
          size: 6,
        },
        yaxis: {
          title: {
            text: "Berat Badan (Kg)",
          },
          min: 0,
        },
        legend: {
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
        this.series = response.data.series;
        this.dataEdit = response.data;
        for (let i = 0; i < this.dataEdit.length; i++) {
          this.isLoading[i] = false;
        }
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
        } else {
          Swal.fire({
            toast: true,
            position: "top",
            iconColor: "white",
            color: "white",
            background: "rgb(var(--v-theme-warning))",
            showConfirmButton: false,
            timerProgressBar: true,
            timer: 4000,
            icon: "warning",
            title: response.data.warning.message,
          });
        }
        this.fetchData();
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
