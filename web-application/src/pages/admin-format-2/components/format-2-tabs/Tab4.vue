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
                        <VCol cols="12" class="d-flex gap-2 align-center">
                            <ImportExcelFormat2 />

                            <VBtn prepend-icon="bx-download" @click="exportExcel">
                                Data
                            </VBtn>

                            <VDialog v-model="dialog" persistent width="1024">
                                <template #activator="{ props }">
                                    <VBtn color="primary" v-bind="props" prepend-icon="bx-download">
                                        Laporan
                                    </VBtn>
                                </template>
                                <VCard>
                                    <VCardTitle>
                                        <span class="text-h5">Ubah Data</span>
                                    </VCardTitle>
                                    <VCardItem>
                                        <VContainer>
                                            <VRow>
                                                <VCol cols="12">
                                                    <VSelect v-model="bulan" :items="itemBulan"
                                                        label="Pilih bulan laporan" placeholder="Pilih bulan" />
                                                </VCol>
                                            </VRow>
                                        </VContainer>
                                    </VCardItem>
                                    <VCardActions>
                                        <VSpacer></VSpacer>
                                        <VBtn color="secondary" variant="text" @click="dialog = false">
                                            Batal
                                        </VBtn>
                                        <VBtn color="primary" variant="text" @click="
                                            exportExcelLaporan();
                                        dialog = false;
                                        ">
                                            Download
                                        </VBtn>
                                    </VCardActions>
                                </VCard>
                            </VDialog>
                        </VCol>
                    </VRow>
                    <VTable>
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Nama Anak</th>
                                <th>Umur</th>
                                <th>Bulan</th>
                                <th>Kelamin</th>
                                <th>Berat Badan</th>
                                <th>N/T/O/B & BGM</th>
                                <th style="width: 220px">Aksi</th>
                            </tr>
                        </thead>

                        <tbody>
                            <VProgressCircular v-if="isLoading" indeterminate color="primary" class="mt-5 float-center"
                                size="50">
                            </VProgressCircular>

                            <tr v-for="(item, index) in dataFormatBA" v-else :key="item.dessert">
                                <td>
                                    {{ (page - 1) * 20 + (index + 1) }}
                                </td>
                                <td>
                                    {{ item.nama_bayi }}
                                </td>
                                <td class="text-center">{{ item.umur }} Bulan</td>
                                <td class="text-center">
                                    {{ item.bulan }}
                                </td>
                                <td class="text-center">
                                    {{ item.jenis_kelamin }}
                                </td>
                                <td class="text-center">
                                    <p v-if="item.berat_badan">{{ item.berat_badan }}</p>
                                    <p v-else> - </p>
                                </td>
                                <td class="text-center">
                                    <p v-if="item.ntob">{{ item.ntob }}</p>
                                    <p v-else> - </p>
                                </td>
                                <td class="text-center">
                                    <VBtn color="primary" class="ml-2"
                                        :href="`/admin/data/format-2-edit?id_bayi=${item.id_bayi}`">
                                        <VIcon>bx-edit</VIcon>
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
            <Font>Jumlah data: <Font class="text-primary">{{ jumlahData }}</Font>
            </Font>
            <VPagination v-model="page" class="float-right" :length="banyakPage" :total-visible="6" @click="fetchData">
            </VPagination>
        </VCol>
    </VRow>
</template>

<script>
import axios from "axios";
import config from "@/@core/config";
import ImportExcelFormat2 from "../import-excel-format-2.vue";

export default {
    components: {
        ImportExcelFormat2,
    },
    data() {
        const d = new Date();

        return {
            dialog: false,
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
            bulan: d.getMonth() + 1,
            listTahunLahir: [d.getFullYear()],
            itemBulan: [
                { value: 1, title: 'Januari' },
                { value: 2, title: 'Februari' },
                { value: 3, title: 'Maret' },
                { value: 4, title: 'April' },
                { value: 5, title: 'Mei' },
                { value: 6, title: 'Juni' },
                { value: 7, title: 'Juli' },
                { value: 8, title: 'Agustus' },
                { value: 9, title: 'September' },
                { value: 10, title: 'Oktober' },
                { value: 11, title: 'November' },
                { value: 12, title: 'Desember' },
            ],
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
    async mounted() {
        const response = await this.fetchData();

        this.judulFormatBA = response.data.judul_format;
        this.namaPosyandu = response.data.nama_posyandu;
        this.kota = response.data.kota;

        const response2 = await axios.get(`${config.urlServer}/api/listtahun?tab=4`, {
            headers: {
                Authorization: localStorage.getItem("tokenAuth"),
            },
        });

        this.listTahunLahir = response2.data;
    },
    methods: {

        async exportExcelLaporan() {
            const response = await axios({
                method: "get",
                url: `${config.urlServer}/api/export/laporan-b?tahun=${this.tahun}&bulan=${this.bulan}`,
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
            const namaFile = `Format-1${currentDateTime}.xlsx`;

            const url = window.URL.createObjectURL(new Blob([response.data]));
            const link = document.createElement("a");

            link.href = url;
            link.setAttribute("download", namaFile);
            document.body.appendChild(link);
            link.click();
        },
        async exportExcel() {
            const response = await axios({
                method: "get",
                url: `${this.urlServer}/api/export/format-b?tahun=${this.tahun}&tab=4`,
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
            const namaFile = `Format-2_tab-4${currentDateTime}.xlsx`;

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
                `${config.urlServer}/api/format-ba?length=20&start=${this.page}&tahun=${this.tahun}&search=${this.dataSearch}&tab=4`,
                {
                    headers: {
                        Authorization: localStorage.getItem("tokenAuth"),
                    },
                },
            );

            this.banyakPage = Math.ceil(response.data.jumlah_data / 20);
            this.jumlahData = response.data.jumlah_data;
            this.dataFormatBA = response.data.format_ba;
            this.isLoading = false;

            return response;
        },
    },
};
</script>