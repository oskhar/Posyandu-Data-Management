<script setup>
import AnalyticsCongratulations from "@/views/dashboard/AnalyticsCongratulations.vue";
import AnalyticsFinanceTabs from "@/views/dashboard/AnalyticsFinanceTab.vue";
import AnalyticsOrderStatistics from "@/views/dashboard/AnalyticsOrderStatistics.vue";
import AnalyticsProfitReport from "@/views/dashboard/AnalyticsProfitReport.vue";
import AnalyticsTotalRevenue from "@/views/dashboard/AnalyticsTotalRevenue.vue";
import AnalyticsTransactions from "@/views/dashboard/AnalyticsTransactions.vue";

// 👉 Images
import chart from "@images/cards/chart-success.png";
import wallet from "@/assets/images/pages/3.png";
</script>

<template>
  <VRow>
    <VCol>
      <VBtn class="float-right"> Upload Image </VBtn>
    </VCol>
  </VRow>
  <VRow>
    <VCol cols="12" md="4">
      <img style="width: 100%" :src="wallet" alt="image" />
    </VCol>
    <VCol cols="12" md="4">
      <img style="width: 100%" :src="wallet" alt="image" />
    </VCol>
    <VCol cols="12" md="4">
      <img style="width: 100%" :src="wallet" alt="image" />
    </VCol>
  </VRow>
</template>
