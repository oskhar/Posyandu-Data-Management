<script setup>
import { useRoute } from "vue-router";
import ReadEdukasi from "@/views/pages/edukasi/ReadEdukasi.vue";
import CreateEdukasi from "@/views/pages/edukasi/CreateEdukasi.vue";
// import AccountSettingsSecurity from "@/views/pages/";

const route = useRoute();
const activeTab = ref(route.params.tab);

// tabs
const tabs = [
  {
    title: "lihat",
    icon: "bx-book-open",
    tab: "read",
  },
  {
    title: "buat",
    icon: "bx-book-add",
    tab: "create",
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

    <VWindow v-model="activeTab" class="mt-5">
      <!-- read -->
      <VWindowItem value="read">
        <ReadEdukasi />
      </VWindowItem>

      <!-- create -->
      <VWindowItem value="create">
        <CreateEdukasi />
      </VWindowItem>
    </VWindow>
  </div>
</template>
