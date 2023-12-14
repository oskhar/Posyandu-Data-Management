<template>
  <VCard>
    <VCardItem>
      <VTabs v-model="currentTab" class="v-tabs-pill">
        <VTab value="berita">
          Berita
        </VTab>
        <VTab value="edukasi">
          edukasi
        </VTab>
        <VTab value="gambar">
          gambar
        </VTab>
      </VTabs>
    </VCardItem>

    <VCardText class="d-flex align-center gap-3">
      <VAvatar size="46" rounded :image="tabData[currentTab].avatar" />

      <div>
        <p class="mb-0">
          {{ tabData[currentTab].title }}
        </p>
        <div class="d-flex align-center gap-2">
          <h6 class="text-h6">
            {{ tabData[currentTab].stats }}
          </h6>
        </div>
      </div>
    </VCardText>

    <VCardText>
      <VueApexCharts type="area" :height="241" :options="chartConfig" :series="series[currentTab]" />
    </VCardText>

    <VCardText class="d-flex align-center justify-center gap-3">
      <VProgressCircular size="45" :model-value="tabData[currentTab].gambarLoss">
        <span class="text-xs text-medium-emphasis">{{ tabData[currentTab].gambarLossAmount }}</span>
      </VProgressCircular>

      <div>
        <h6 class="text-base font-weight-regular">
          <span class="text-capitalize">{{ currentTab }}</span>
          <span> minggu ini</span>
        </h6>
        <span class="text-sm text-disabled">{{ tabData[currentTab].compareToLastWeek }}</span>
      </div>
    </VCardText>
  </VCard>
</template>
<script>
import VueApexCharts from 'vue3-apexcharts'
import { useTheme } from 'vuetify'
import statsVerticalChart from '@images/cards/chart-success.png'
import statsVerticalPaypal from '@images/cards/paypal-error.png'
import statsVerticalWallet from '@images/cards/wallet-primary.png'
import { hexToRgb } from '@layouts/utils'
import config from '@/@core/config.vue'
import axios from 'axios'

export default {
  components: {
    VueApexCharts,
    statsVerticalChart,
    statsVerticalPaypal,
    statsVerticalWallet,
  },
  data() {
    const vuetifyTheme = useTheme()
    const currentTheme = vuetifyTheme.current.value.colors
    const variableTheme = vuetifyTheme.current.value.variables
    const disabledTextColor = `rgba(${hexToRgb(String(currentTheme['on-surface']))},${variableTheme['disabled-opacity']})`
    const borderColor = `rgba(${hexToRgb(String(variableTheme['border-color']))},${variableTheme['border-opacity']})`
    return {
      currentTab: 'berita',
      tabData: {
        berita: {
          avatar: statsVerticalWallet,
          title: 'Berita acara',
          stats: '0',
          gambarLoss: 0,
          gambarLossAmount: '0',
          compareToLastWeek: '0',
        },
        edukasi: {
          avatar: statsVerticalPaypal,
          title: 'Edukasi',
          stats: '0',
          gambarLoss: 0,
          gambarLossAmount: '0',
          compareToLastWeek: '0',
        },
        gambar: {
          avatar: statsVerticalChart,
          title: 'gambar',
          stats: '0',
          gambarLoss: 0,
          gambarLossAmount: '0',
          compareToLastWeek: '0',
        },
      },
      series: {
        berita: [{
          name: 'Berita',
          data: [
            0,
            0,
            0,
            0,
            0,
            0,
            0,
          ],
        }],
        edukasi: [{
          name: 'Edukasi',
          data: [
            0,
            0,
            0,
            0,
            0,
            0,
          ],
        }],
        gambar: [{
          name: 'Gambar',
          data: [
            0,
            0,
            0,
            0,
            0,
            0,
            0,
          ],
        }],
      },
      chartConfig: {
        chart: {
          parentHeightOffset: 0,
          toolbar: { show: false },
        },
        dataLabels: { enabled: false },
        stroke: {
          width: 3,
          curve: 'smooth',
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
          type: 'gradient',
          gradient: {
            opacityTo: 0.25,
            opacityFrom: 0.5,
            stops: [
              0,
              95,
              100,
            ],
            shadeIntensity: 0.6,
            colorStops: [[
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
            ]],
          },
        },
        theme: {
          monochrome: {
            enabled: true,
            shadeTo: 'light',
            shadeIntensity: 1,
            color: currentTheme.primary,
          },
        },
        xaxis: {
          axisTicks: { show: false },
          axisBorder: { show: false },
          categories: [
            '',
            'senin',
            'Selasa',
            'rabu',
            'kamis',
            'jumat',
            'sabtu',
          ],
          labels: {
            style: {
              fontSize: '14px',
              colors: disabledTextColor,
              fontFamily: 'Public Sans',
            },
          },
        },
        yaxis: {
          min: 0,
          show: false,
          tickAmount: 4,
        },
        markers: {
          size: 8,
          strokeWidth: 6,
          strokeOpacity: 1,
          hover: { size: 8 },
          colors: ['transparent'],
          strokeColors: 'transparent',
          discrete: [{
            size: 8,
            seriesIndex: 0,
            fillColor: '#fff',
            strokeColor: currentTheme.primary,
            dataPointIndex: 6,
          }],

        },
      },
    }
  },
  methods: {
    async fetchData() {
      const response = await axios.get(
        `${config.imagePath}/api/statistik/dashboard`,
        {
          headers: {
            Authorization: localStorage.getItem('tokenAuth')
          }
        }
      );
      this.series = {
        berita: [{
          data: Object.values(response.data.berita.statistik),
        }],
        edukasi: [{
          data: Object.values(response.data.edukasi.statistik),
        }],
        gambar: [{
          data: Object.values(response.data.gambar.statistik),
        }],
      }
      this.tabData = {
        berita: {
          avatar: statsVerticalWallet,
          title: 'Berita acara',
          stats: response.data.berita.jumlah_hari_ini,
          gambarLoss: response.data.berita.persentase_perubahan_minggu_lalu,
          gambarLossAmount: response.data.berita.jumlah_minggu_ini,
          compareToLastWeek: response.data.berita.bandingkan_minggu_lalu,
        },
        edukasi: {
          avatar: statsVerticalPaypal,
          title: 'Edukasi',
          stats: response.data.edukasi.jumlah_hari_ini,
          gambarLoss: response.data.edukasi.persentase_perubahan_minggu_lalu,
          gambarLossAmount: response.data.edukasi.jumlah_minggu_ini,
          compareToLastWeek: response.data.edukasi.bandingkan_minggu_lalu,
        },
        gambar: {
          avatar: statsVerticalChart,
          title: 'gambar',
          stats: response.data.gambar.jumlah_hari_ini,
          gambarLoss: response.data.gambar.persentase_perubahan_minggu_lalu,
          gambarLossAmount: response.data.gambar.jumlah_minggu_ini,
          compareToLastWeek: response.data.gambar.bandingkan_minggu_lalu,
        },
      }
    },
  },
  async mounted() {
    this.fetchData()
  }

}
</script>