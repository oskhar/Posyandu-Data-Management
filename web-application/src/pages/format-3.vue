<template>
    <VRow>
        <VCol cols="12">
            <VCard>
                <VProgressCircular v-if="isLoading" indeterminate color="primary" class="mt-5 float-center" size="50">
                </VProgressCircular>
                <VCardItem v-else style="min-height: 170px">
                    <h2>{{ judulFormatBA }}</h2>
                    <h3 class="text-secondary mt-5">{{ namaPosyandu }} - {{ kota }}</h3>
                </VCardItem>
                <VCardItem>
                    <VSelect v-model="tahun" :items="listTahunLahir" />
                </VCardItem>
            </VCard>
        </VCol>

        <VCol cols="12">
            <VCard>
                <!-- <VCardText> </VCardText> -->
                <VCardItem>
                    <VRow>
                        <VCol cols="12">
                            <VTextField v-model="dataSearch" append-inner-icon="bx-search">
                            </VTextField>
                        </VCol>
                        <VCol cols="12">
                            <VBtn class="mb-3" href="/data/format-3-create" prepend-icon="bx-plus">
                                Tambah
                            </VBtn>
                            <VBtn class="ml-4 mb-3" @click="exportExcel" prepend-icon="bx-download">
                                Download
                            </VBtn>
                        </VCol>
                    </VRow>
                    <VTable>
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Nama Wus & Pus</th>
                                <th>Umur</th>
                                <th>Nama Suami</th>
                                <th>Tahapan KS</th>
                                <th style="width: 220px">Aksi</th>
                            </tr>
                        </thead>

                        <tbody>
                            <VProgressCircular v-if="isLoading" indeterminate color="primary" class="mt-5 float-center"
                                size="50">
                            </VProgressCircular>

                            <tr v-else v-for="(item, index) in dataFormatBA" :key="item.dessert">
                                <td>
                                    {{ (page - 1) * 20 + (index + 1) }}
                                </td>
                                <td>
                                    {{ item.nama_ibu }}
                                </td>
                                <td class="text-center">{{ item.umur }} Bulan</td>
                                <td class="text-center">
                                    {{ item.nama_ayah }}
                                </td>
                                <td class="text-center">
                                    {{ item.tahapan_ks }}
                                </td>
                                <td class="text-center">
                                    <VBtn color="primary" class="ml-2"
                                        :href="`/data/format-2-edit?id_bayi=${item.id_bayi}`">
                                        <v-icon>bx-edit</v-icon>
                                    </VBtn>
                                </td>
                            </tr>
                        </tbody>
                    </VTable>
                </VCardItem>
            </VCard>
        </VCol>
    </VRow>
    <VRow>
        <VCol>
            <font>Jumlah data: <font class="text-primary">{{ jumlahData }}</font>
            </font>
            <v-pagination class="float-right" v-model="page" :length="banyakPage" :total-visible="4"
                @click="fetchData"></v-pagination>
        </VCol>
    </VRow>
</template>
  
<script>
//import EditEdukasi from "./EditEdukasi.vue";
import axios from "axios";
import AnalyticsBarCharts from "@/views/dashboard/AnalyticsBarCharts.vue";
import config from "@/@core/config.vue";
import VueApexCharts from "vue3-apexcharts";

export default {
    data() {
        const d = new Date();
        return {
            dataSearch: "",
            urlServer: config.urlServer,
            page: 1,
            banyakPage: 5,
            dataFormatBA: [],
            judulFormatBA: "",
            namaPosyandu: "",
            kota: "",
            jumlahData: 0,
            jumlahLahiran: "",
            jumlahMeninggal: "",
            tahun: d.getFullYear(),
            listTahunLahir: [d.getFullYear()],
            isLoading: false,
            chartOptions: {},
        };
    },

    watch: {
        // Properti tahun akan dipantau
        tahun: function () {
            // Ketika tahun berubah, panggil fungsi fetchData
            this.page = 1;
            this.fetchData();
        },
        dataSearch: function () {
            this.fetchData();
        },
        bulan: function () {
            // Ketika tahun berubah, panggil fungsi fetchData
            this.page = 1;
            this.fetchData();
        },
    },
    methods: {
        async exportExcel() {
            const response = await axios({
                method: "get",
                url: `${this.urlServer}/api/export/format-b?tahun=${this.tahun}&tab=1`,
                responseType: "blob",
                headers: {
                    Authorization: localStorage.getItem("tokenAuth"),
                },
            });
            // Membuat objek Date yang merepresentasikan waktu saat ini
            const currentDate = new Date();

            // Mendapatkan tahun, bulan, tanggal, jam, menit, dan detik
            const year = currentDate.getFullYear();
            const month = currentDate.getMonth() + 1; // Perlu ditambah 1 karena indeks bulan dimulai dari 0
            const day = currentDate.getDate();
            const hours = currentDate.getHours();
            const minutes = currentDate.getMinutes();
            const seconds = currentDate.getSeconds();
            const currentDateTime = `_${year}-${month}-${day}_${hours}:${minutes}:${seconds}`;
            const namaFile = `Format-2_tab-1${currentDateTime}.xlsx`;

            const url = window.URL.createObjectURL(new Blob([response.data]));
            const link = document.createElement("a");
            link.href = url;
            link.setAttribute("download", namaFile);
            document.body.appendChild(link);
            link.click();
        },
        async fetchData() {
            this.isLoading = true;
            const response = await axios.get(
                `${config.urlServer}/api/format-ba?length=20&start=${this.page}&tahun=${this.tahun}&search=${this.dataSearch}&tab=1`,
                {
                    headers: {
                        Authorization: localStorage.getItem("tokenAuth"),
                    },
                }
            );
            this.banyakPage = Math.ceil(response.data.jumlah_data / 20);
            this.jumlahData = response.data.jumlah_data;
            this.dataFormatBA = response.data.format_ba;
            this.isLoading = false;
            return response;
        },
    },
    components: {
        AnalyticsBarCharts,
        VueApexCharts,
    },
    async mounted() {
        const response = await this.fetchData();
        this.judulFormatBA = response.data.judul_format;
        this.namaPosyandu = response.data.nama_posyandu;
        this.kota = response.data.kota;
        const response2 = await axios.get(`${config.urlServer}/api/listtahun?tab=1`, {
            headers: {
                Authorization: localStorage.getItem("tokenAuth"),
            },
        });
        this.listTahunLahir = response2.data;
    },
};
</script>
  