<script setup>
import { ref } from 'vue';
import ListDraftSuratTugas from './draft-surat-tugas/list-draft-surat-tugas.vue';
import BuatSuratTugas from './buat-surat-tugas/buat-surat-tugas.vue';
import ListHistorySuratTugas from './history-surat-tugas/list-history-surat-tugas.vue';


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

const createSurat = surat => {
  console.log(surat);
}
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
    <VWindowItem value="buat-surat">
      <BuatSuratTugas @create="createSurat" />
    </VWindowItem>

    <VWindowItem value="draft-surat">
      <ListDraftSuratTugas />
    </VWindowItem>

    <VWindowItem value="histori-surat">
      <ListHistorySuratTugas />
    </VWindowItem>
  </VWindow>
</template>