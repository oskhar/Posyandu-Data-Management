<script setup>
import { pdfBase64 } from '@/utils/file';
import { ref } from 'vue';
import PreviewSuratTugas from '../preview-surat-tugas.vue';

/**
 * @type {{surat: import("@/pages/kader-gendong/api/surat-tugas-api").SuratTugas}}
 */
const { surat } = defineProps({
	surat: { type: Object, required: true },
});

const isDialogActive = ref(false);
</script>

<template>
	<VCard style="height: 312px;" class="cursor-pointer" @click="isDialogActive = true">
		<VCardItem class="border-b-md pb-3">
			<p class="text-subtitle-1 mb-1 font-black">No. Surat: {{ surat.nomor }}</p>
			<p class="text-subtitle-2 mb-1 font-black">Penanda Tangan: {{ surat.penanda_tangan }}</p>
			<p class="text-subtitle-2 mb-1 font-black">Tanggal Surat: {{ new Date(surat.tanggal_surat).toLocaleDateString() }}
			</p>
		</VCardItem>
		<VCardText class="position-relative text-justify mt-2">
			<p class="text-subtitle-1 mb-0">Isi Surat:</p>
			<div class="text-subtitle-2" v-html="surat.isi_surat" />
			<div class="fade-overlay position-absolute h-100 left-0 right-0 bottom-0" />
		</VCardText>
	</VCard>

	<PreviewSuratTugas :is-dialog-active="isDialogActive" :base64-surat="pdfBase64(surat.file)"
		@update:is-dialog-active="isDialogActive = $event" />
</template>

<style lang="scss" scoped>
.fade-overlay {
	background: linear-gradient(to bottom, transparent, rgb(var(--v-theme-surface)) 55%);
	pointer-events: none;
}
</style>
