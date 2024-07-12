<script setup>
import { ref } from 'vue';
import ListDraftSuratTugas from './components/draft-surat-tugas/list-draft-surat-tugas.vue';
import BuatSuratTugas from './components/buat-surat-tugas/buat-surat-tugas.vue';
import ListHistorySuratTugas from './components/history-surat-tugas/list-history-surat-tugas.vue';
import { createSuratTugas } from './api/surat-tugas-api';
import { getErrorMessage } from '@/utils/get-error-message';
import Swal from 'sweetalert2';
import { createDownload } from '@/utils/create-download';

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

const createSurat = async surat => {
  try {
    const result = await createSuratTugas(surat);

    createDownload(result.file)

    await Swal.fire({
      icon: 'success',
      title: 'Berhasil membuat surat',
      text: result.message,
    })
  } catch (error) {
    await Swal.fire({
      icon: 'error',
      title: 'Gagal membuat surat tugas',
      text: getErrorMessage(error, 'Gagal membuat surat tugas!'),
    })
  }
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