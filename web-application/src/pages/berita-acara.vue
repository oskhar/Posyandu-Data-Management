<script setup>
import { useRoute } from "vue-router";
import ReadBeritaAcara from "@/views/pages/berita-acara/ReadBeritaAcara.vue";
import CreateBeritaAcara from "@/views/pages/berita-acara/CreateBeritaAcara.vue";
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
        <ReadBeritaAcara />
      </VWindowItem>

      <!-- create -->
      <VWindowItem value="create">
        <CreateBeritaAcara />
      </VWindowItem>
    </VWindow>
  </div>
</template>
