<script setup>
import { useRoute } from "vue-router";
import Tab1 from "@/views/pages/format-2/Tab1.vue";
import Tab2 from "@/views/pages/format-2/Tab2.vue";
import Tab3 from "@/views/pages/format-2/Tab3.vue";
import Tab4 from "@/views/pages/format-2/Tab4.vue";
// import AccountSettingsSecurity from "@/views/pages/";

const route = useRoute();
const activeTab = ref(route.params.tab);

// tabs
const tabs = [
  {
    title: "0-5 Bulan",
    icon: "bx-book-add",
    tab: "tab1",
  },
  {
    title: "6-11 Bulan",
    icon: "bx-book-add",
    tab: "tab2",
  },
  {
    title: "12-23 Bulan",
    icon: "bx-book-add",
    tab: "tab3",
  },
  {
    title: "24-59 Bulan",
    icon: "bx-book-add",
    tab: "tab4",
  },
];
</script>

<template>
  <div>
    <VTabs v-model="activeTab" show-arrows>
      <VTab v-for="item in tabs" :key="item.icon" :value="item.tab">
        <VIcon size="20" start :icon="item.icon" />
        {{ item.title }}
      </VTab>
    </VTabs>
    <VDivider />

    <VWindow v-model="activeTab" class="mt-5" :touch="false">
      <!-- read -->
      <VWindowItem value="tab1">
        <Tab1 />
      </VWindowItem>
      <!-- create -->
      <VWindowItem value="tab2">
        <Tab2 />
      </VWindowItem>
      <VWindowItem value="tab3">
        <Tab3 />
      </VWindowItem>
      <VWindowItem value="tab4">
        <Tab4 />
      </VWindowItem>
    </VWindow>
  </div>
</template>
