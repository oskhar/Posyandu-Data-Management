<script setup>
import { ref, computed, onMounted } from "vue";
import VueApexCharts from "vue3-apexcharts";
import Swal from "sweetalert2";
import { getSwalErrorMessage } from "@/utils/get-error-message";
import { useRoute, useRouter } from "vue-router";
import { api } from "@/lib/api";

const router = useRouter();
const route = useRoute();

const pilihHasil = ref([]);


const pilihPelayanan = ref([]);
const isLoading = ref(false);
const series = ref([]);

const dataEdit = ref({
  bayi: {
    nama: "",
    tanggal_lahir: "",
    jenis_kelamin: "",
    berat_lahir: null,
    keterangan: null,
  },
  penimbangan: [],
});

const chartOptions = ref({
  chart: {
    height: 350,
    type: "line",
    zoom: {
      enabled: false,
    },
  },
  toolBar: {
    tools: {
      download: '<img src="/static/icons/download.png" class="ico-download" width="20">',
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
    "#696CFF",
  ],
  xaxis: {
    title: {
      text: "Umur Bayi (bulan)",
    },
    categories: [],
    labels: {
      formatter: value => {
        return `${value - 1}`;
      },
    },
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
  legend: {},
});

const fetchData = async () => {
  try {
    const idBalita = route.params.idBalita;

    const response = await api.get(
      `/format-ba`,
      { params: { id_bayi: idBalita } },
    );

    pilihHasil.value = response.data.hasil_penimbangan;
    pilihPelayanan.value = response.data.pelayanan;
    series.value = response.data.series;
    dataEdit.value = response.data;

    for (let i = 0; i < dataEdit.value.length; i++) {
      isLoading.value[i] = false;
    }

  } catch (error) {
    await Swal.fire({
      icon: "error",
      title: "Gagal mengambil data",
      html: getSwalErrorMessage(error),
    });

    router.push("/layanan/screening-balita");
  }

};


onMounted(fetchData);
</script>

<template>
  <VRow tag="section" class="px-5 mb-4">
    <VCol cols="12" md="9" class="mx-auto">
      <VRow>
        <VBtn prepend-icon="bx-left-arrow-alt" variant="text" to="/layanan/screening-balita" class="mb-4">
          Kembali
        </VBtn>

        <VCol cols="12">
          <VCard>
            <VCardItem>
              <h1 class="text-center">
                <VIcon>{{ dataEdit.bayi.jenis_kelamin == "L" ? "bx-male" : "bx-female" }}</VIcon>Grafik {{
                  dataEdit.bayi.jenis_kelamin == "L" ? "Laki Laki" : "Perempuan" }}
              </h1>
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
                    <span class="float-right">{{ dataEdit.bayi.nama }}</span>
                  </p>
                  <hr class="text-primary mb-5" style="border-style: dashed;opacity: 0.5;">
                  <p class="mb-4">
                    Nama Ayah:
                    <span class="float-right">{{ dataEdit.bayi.nama_ayah }}</span>
                  </p>
                  <hr class="text-primary mb-5" style="border-style: dashed;opacity: 0.5;">
                  <p class="mb-4">
                    Nama Ibu:
                    <span class="float-right">{{ dataEdit.bayi.nama_ibu }}</span>
                  </p>
                  <hr class="text-primary mb-5" style="border-style: dashed;opacity: 0.5;">
                  <p class="mb-4">
                    Tanggal Lahir:
                    <span class="float-right">{{
                      dataEdit.bayi.tanggal_lahir
                    }}</span>
                  </p>
                  <hr class="text-primary mb-5" style="border-style: dashed;opacity: 0.5;">
                  <p class="mb-4">
                    Jenis Kelamin:<span class="float-right">
                      {{ dataEdit.bayi.jenis_kelamin == "L" ? "Laki Laki" : "Perempuan" }}
                    </span>
                  </p>
                  <hr class="text-primary mb-5" style="border-style: dashed;opacity: 0.5;">
                  <p class="mb-4">
                    BB Saat Lahir :<span class="float-right">
                      {{
                        dataEdit.bayi.berat_lahir
                          ? dataEdit.bayi.berat_lahir + " KG"
                          : "-"
                      }}
                    </span>
                  </p>
                </VCol>
                <VCol v-for="(item, index) in dataEdit.penimbangan" :key="index" cols="12">
                  <hr class="mb-5" style="opacity: 0.3;">
                  <h4 class="my-5">{{ item.judul }}</h4>
                  <VRow>
                    <VCol cols="12" sm="12" md="6" lg="6">
                      <VTextField v-model="dataEdit.penimbangan[index].berat_badan" label="Berat Badan"
                        placeholder="Masukkan Berat Badan" :rules="[
                          (input) => (input >= 0) || 'Berat badan tidak bisa negatif'
                        ]" readonly />
                    </VCol>
                    <VCol v-if="index <= 6" cols="12" sm="12" md="6" lg="6">
                      <VTextField v-model="dataEdit.penimbangan[index].asi_eksklusif" label="Asi Eksklusif" readonly
                        placeholder="Masukkan Asi Ekslusif" :items="['Ya', 'Tidak', 'Alpa']" />
                    </VCol>
                    <VCol cols="12" sm="12" md="6" lg="6">
                      <VTextField v-model="dataEdit.penimbangan[index].lila" label="Lila" placeholder="Masukkan Lila"
                        :rules="[
                          (input) => (input >= 0) || 'Lila tidak bisa negatif'
                        ]" readonly />
                    </VCol>
                    <VCol cols="12" sm="12" md="6" lg="6">
                      <VTextField v-model="dataEdit.penimbangan[index].lingkar_kepala" label="Lingkar Kepala"
                        placeholder="Masukkan Lingkar Kepala" :rules="[
                          (input) => (input >= 0) || 'Lingkar Kepala tidak bisa negatif'
                        ]" readonly />
                    </VCol>
                    <VCol cols="12" sm="12" md="6" lg="6">
                      <VTextField v-model="dataEdit.penimbangan[index].tinggi_badan" label="Tinggi Badan"
                        placeholder="Masukkan Tinggi Badan" :rules="[
                          (input) => (input >= 0) || 'Tinggi badan tidak bisa negatif'
                        ]" readonly />
                    </VCol>
                    <VCol cols="12" sm="12" md="6" lg="6">
                      <VTextField v-model="dataEdit.penimbangan[index].cara_ukur" readonly label="Cara Ukur"
                        placeholder="Cara ukur" :items="['Berdiri', 'Telentang']" />
                    </VCol>
                    <VCol v-if="index > 5" cols="12" sm="12" md="6" lg="6">
                      <VCheckbox v-model="dataEdit.penimbangan[index].vit_a" readonly label="Mendapatkan Vitamin A" />
                    </VCol>
                  </VRow>
                </VCol>
              </VRow>
            </VCardText>
          </VCard>
        </VCol>
      </VRow>
    </VCol>
  </VRow>
</template>