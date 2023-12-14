<script setup>
import VueApexCharts from "vue3-apexcharts";
import { useTheme } from "vuetify";
import statsVerticalChart from "@images/cards/chart-success.png";
import statsVerticalPaypal from "@images/cards/paypal-error.png";
import statsVerticalWallet from "@images/cards/wallet-primary.png";
import { hexToRgb } from "@layouts/utils";
import config from "@/@core/config.vue";
import axios from "axios";

const vuetifyTheme = useTheme();

let series = {
  berita: [
    {
      data: [24, 21, 30, 22, 42, 26, 35, 29],
    },
  ],
  edukasi: [
    {
      data: [24, 21, 30, 25, 42, 26, 35, 29],
    },
  ],
  gambar: [
    {
      data: [24, 21, 30, 22, 42, 26, 35, 35],
    },
  ],
};

const currentTab = ref("berita");

const tabData = computed(async () => {
  const response = await axios.get(
    `${config.urlServer}/api/statistik/dashboard`,
    { headers: { Authorization: localStorage.getItem("tokenAuth") } }
  );
  series = {
    berita: [
      {
        data: Object.values(response.data.berita.statistik),
      },
    ],
    edukasi: [
      {
        data: Object.values(response.data.edukasi.statistik),
      },
    ],
    gambar: [
      {
        data: Object.values(response.data.gambar.statistik),
      },
    ],
  };
  console.log(series);
  const data = {
    berita: {
      avatar: statsVerticalWallet,
      title: "Berita acara",
      stats: toString(response.data.berita.jumlah_hari_ini),
      gambarLoss: toString(response.data.berita.persentase_perubahan_kemarin),
      gambarLossAmount: toString(response.data.berita.jumlah_minggu_ini),
      compareToLastWeek: toString(
        response.data.berita.bandingkan_dengan_minggu_lalu
      ),
    },
    edukasi: {
      avatar: statsVerticalPaypal,
      title: "Edukasi",
      stats: response.data.edukasi.jumlah_hari_ini,
      gambarLoss: response.data.edukasi.persentase_perubahan_kemarin,
      gambarLossAmount: response.data.edukasi.jumlah_minggu_ini,
      compareToLastWeek: response.data.edukasi.bandingkan_dengan_minggu_lalu,
    },
    gambar: {
      avatar: statsVerticalChart,
      title: "gambar",
      stats: response.data.gambar.jumlah_hari_ini,
      gambarLoss: response.data.gambar.persentase_perubahan_kemarin,
      gambarLossAmount: response.data.gambar.jumlah_minggu_ini,
      compareToLastWeek: response.data.gambar.bandingkan_dengan_minggu_lalu,
    },
  };

  return data[currentTab.value];
});

const chartConfig = computed(() => {
  const currentTheme = vuetifyTheme.current.value.colors;
  const variableTheme = vuetifyTheme.current.value.variables;
  const disabledTextColor = `rgba(${hexToRgb(
    String(currentTheme["on-surface"])
  )},${variableTheme["disabled-opacity"]})`;
  const borderColor = `rgba(${hexToRgb(
    String(variableTheme["border-color"])
  )},${variableTheme["border-opacity"]})`;

  return {
    chart: {
      parentHeightOffset: 0,
      toolbar: { show: false },
    },
    dataLabels: { enabled: false },
    stroke: {
      width: 3,
      curve: "smooth",
    },
    grid: {
      strokeDashArray: 4.5,
      borderColor,
      padding: {
        left: 0,
        top: -20,
        right: 11,
        bottom: 7,
      },
    },
    fill: {
      type: "gradient",
      gradient: {
        opacityTo: 0.25,
        opacityFrom: 0.5,
        stops: [0, 95, 100],
        shadeIntensity: 0.6,
        colorStops: [
          [
            {
              offset: 0,
              opacity: 0.4,
              color: currentTheme.primary,
            },
            {
              offset: 100,
              opacity: 0.2,
              color: currentTheme.surface,
            },
          ],
        ],
      },
    },
    theme: {
      monochrome: {
        enabled: true,
        shadeTo: "light",
        shadeIntensity: 1,
        color: currentTheme.primary,
      },
    },
    xaxis: {
      axisTicks: { show: false },
      axisBorder: { show: false },
      categories: ["", "Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul"],
      labels: {
        style: {
          fontSize: "14px",
          colors: disabledTextColor,
          fontFamily: "Public Sans",
        },
      },
    },
    yaxis: {
      min: 10,
      max: 50,
      show: false,
      tickAmount: 4,
    },
    markers: {
      size: 8,
      strokeWidth: 6,
      strokeOpacity: 1,
      hover: { size: 8 },
      colors: ["transparent"],
      strokeColors: "transparent",
      discrete: [
        {
          size: 8,
          seriesIndex: 0,
          fillColor: "#fff",
          strokeColor: currentTheme.primary,
          dataPointIndex: series[currentTab.value][0].data.length - 1,
        },
      ],
    },
  };
});
</script>

<template>
  <VCard>
    <VCardItem>
      <VTabs v-model="currentTab" class="v-tabs-pill">
        <VTab value="berita"> Berita </VTab>
        <VTab value="edukasi"> edukasi </VTab>
        <VTab value="gambar"> gambar </VTab>
      </VTabs>
    </VCardItem>

    <VCardText class="d-flex align-center gap-3">
      <VAvatar size="46" rounded :image="tabData.avatar" />

      <div>
        <p class="mb-0">
          {{ tabData.title }}
        </p>
        <div class="d-flex align-center gap-2">
          <h6 class="text-h6">
            {{ tabData.stats }}
          </h6>
          <span
            class="text-sm"
            :class="tabData.gambarLoss > 0 ? 'text-success' : 'text-error'"
          >
            <VIcon size="24" icon="bx-chevron-up" />
            {{ tabData.gambarLoss }}%
          </span>
        </div>
      </div>
    </VCardText>

    <VCardText>
      <VueApexCharts
        type="area"
        :height="241"
        :options="chartConfig"
        :series="series[currentTab]"
      />
    </VCardText>

    <VCardText class="d-flex align-center justify-center gap-3">
      <VProgressCircular size="45" :model-value="tabData.gambarLoss">
        <span class="text-xs text-medium-emphasis">{{
          tabData.gambarLossAmount
        }}</span>
      </VProgressCircular>

      <div>
        <h6 class="text-base font-weight-regular">
          <span class="text-capitalize">{{ currentTab }}</span>
          <span> minggu ini</span>
        </h6>
        <span class="text-sm text-disabled"
          >{{ tabData.compareToLastWeek }} less than last week</span
        >
      </div>
    </VCardText>
  </VCard>
</template>
