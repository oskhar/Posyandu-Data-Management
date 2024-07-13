<script setup>
import { ref } from 'vue';
import ListDraftSuratTugas from './components/draft-surat-tugas/list-draft-surat-tugas.vue';
import BuatSuratTugas from './components/buat-surat-tugas/buat-surat-tugas.vue';
import ListHistorySuratTugas from './components/history-surat-tugas/list-history-surat-tugas.vue';
import { createSuratTugasHandler } from './handlers/surat-tugas-handler';
import { createDraftSuratTugasHandler } from './handlers/draft-surat-tugas-handler';

// Initialize data
const tabs = [
  {
    title: "Buat Surat",
    icon: "bx-file",
    tab: "buat-surat",
  },
  {
    title: "Draft Surat",
    icon: "bx-folder",
    tab: "draft-surat",
  },
  {
    title: "Histori Surat",
    icon: "bx-list-ul",
    tab: "histori-surat",
  },
];

const activeTab = ref(tabs[0].tab);
</script>

<template>
  <VTabs v-model="activeTab" show-arrows>
    <VTab v-for="item in tabs" :key="item.icon" :value="item.tab">
      <VIcon size="20" start :icon="item.icon" />
      {{ item.title }}
    </VTab>
  </VTabs>
  <VDivider />

  <VWindow v-model="activeTab" class="mt-5 disable-tab-transition">
    <VWindowItem :value="tabs[0].tab">
      <BuatSuratTugas v-if="activeTab === tabs[0].tab" />
    </VWindowItem>

    <VWindowItem :value="tabs[1].tab">
      <ListDraftSuratTugas v-if="activeTab === tabs[1].tab" />
    </VWindowItem>

    <VWindowItem :value="tabs[2].tab">
      <ListHistorySuratTugas v-if="activeTab === tabs[2].tab" />
    </VWindowItem>
  </VWindow>
</template>