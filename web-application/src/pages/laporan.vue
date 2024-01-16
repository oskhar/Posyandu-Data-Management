<template>
    <VRow>
        <VCol cols="12" sm="12">
            <VCard>
                <VCardItem>
                    <VBtn @click="exportExcel">Download Laporan Format 2</VBtn>
                </VCardItem>
            </VCard>
        </VCol>
    </VRow>
    <VRow>
        <VCol cols="12" sm="12">
            <VRow>
                <!-- 👉 Profit -->
                <VCol cols="12" md="4">
                    <CardStatisticsVertical href="/berita-acara" v-bind="{
                        title: 'Jumlah Berita',
                        image: statsVerticalWallet,
                        stats: statBerita,
                    }" />
                </VCol>

                <!-- 👉 Sales -->
                <VCol cols="12" md="4">
                    <CardStatisticsVertical href="/edukasi" v-bind="{
                        title: 'Jumlah Edukasi',
                        image: statsVerticalPaypal,
                        stats: statEdukasi,
                    }" />
                </VCol>
                <VCol cols="12" md="4">
                    <CardStatisticsVertical href="/galeri" v-bind="{
                        title: 'Jumlah Gambar',
                        image: statsVerticalChart,
                        stats: statGambar,
                    }" />
                </VCol>
            </VRow>
        </VCol>
        <VCol cols="12" md="12">
            <StatistikDashboard />
        </VCol>
    </VRow>
</template>
<script>
import StatistikDashboard from "@/views/dashboard/StatistikDashboard.vue";
import config from "@/@core/config.vue";
import axios from "axios";
import statsVerticalChart from "@images/cards/chart-success.png";
import statsVerticalPaypal from "@images/cards/paypal-error.png";
import statsVerticalWallet from "@images/cards/wallet-primary.png";

export default {
    components: {
        StatistikDashboard
    },
    data() {
        return {
            statBerita: 0,
            statEdukasi: 0,
            statGambar: 0,
            statsVerticalChart,
            statsVerticalPaypal,
            statsVerticalWallet,
            tahun: 2024,
            bulan: 1,
        }
    },
    methods: {
        async exportExcel() {
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
        async fetchBerita() {
            const response = await axios.get(`${config.urlServer}/api/berita?start=0&length=0`);
            this.statBerita = response.data.jumlah_data;
        },

        async fetchEdukasi() {
            const response = await axios.get(`${config.urlServer}/api/edukasi?start=0&length=0`);
            this.statEdukasi = response.data.jumlah_data;
        },
        async fetchGambar() {
            const response = await axios.get(`${config.urlServer}/api/gambar?start=0&length=0`);
            this.statGambar = response.data.jumlah_data;
        },
    },
    mounted() {
        this.fetchBerita();
        this.fetchEdukasi();
        this.fetchGambar();
    },
}
</script>