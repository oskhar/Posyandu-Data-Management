<template>
    <VRow>
        <VCol cols="12" sm="12">
            <VRow>
                <!-- 👉 Profit -->
                <VCol cols="12" md="4">
                    <CardStatisticsVertical href="/events" v-bind="{
                        title: 'Jumlah Events',
                        image: statsVerticalWallet,
                        stats: statEvents,
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
import config from "@/@core/config";
import axios from "axios";
import statsVerticalChart from "@images/cards/chart-success.png";
import statsVerticalPaypal from "@images/cards/paypal-error.png";
import statsVerticalWallet from "@images/cards/wallet-primary.png";

export default {
    components: {
        StatistikDashboard,
    },
    data() {
        return {
            statEvents: 0,
            statEdukasi: 0,
            statGambar: 0,
            statsVerticalChart,
            statsVerticalPaypal,
            statsVerticalWallet,
        }
    },
    mounted() {
        this.fetchEvents();
        this.fetchEdukasi();
        this.fetchGambar();
    },
    methods: {
        async fetchEvents() {
            const response = await axios.get(`${config.urlServer}/api/berita?start=0&length=0`);

            this.statEvents = response.data.jumlah_data;
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
}
</script>