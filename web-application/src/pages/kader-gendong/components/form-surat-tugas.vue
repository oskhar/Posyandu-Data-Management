<script setup>
import { QuillEditor } from "@vueup/vue-quill"
import { reactive } from 'vue';
import DOMPurify from 'dompurify';
import DitugaskanTable from "./buat-surat-tugas/ditugaskan-table.vue";

const { listPenandaTangan, surat } = defineProps({
	listPenandaTangan: { type: Array, required: true },
	surat: { type: Object },
});

const emit = defineEmits(['create']);

const suratData = reactive(surat ?? {
	penanda_tangan: listPenandaTangan[0],
	tanggal_surat: new Date(),
	nomor: '',
	kalimat_pembuka: '',
	ditugaskan: [],
	isi_surat: '',
	kalimat_penutup: '',
});

const addDitugaskan = orang => suratData.ditugaskan.push(orang)

const deleteDitugaskan = index => {
	suratData.ditugaskan = suratData.ditugaskan.filter((_, i) => i !== index);
};

const handleCreateSuratTugas = () => {
	emit('create', {
		...suratData,
		kalimat_pembuka: DOMPurify.sanitize(suratData.kalimat_pembuka),
		isi_surat: DOMPurify.sanitize(suratData.isi_surat),
		kalimat_penutup: DOMPurify.sanitize(suratData.kalimat_penutup),
	});
};
</script>

<template>
	<VForm @submit.prevent="handleCreateSuratTugas">
		<VCardItem>
			<VCardTitle>Form Surat Tugas Posyandu</VCardTitle>
		</VCardItem>

		<VCardText>
			<!-- Penanda tangan dan tanggal surat -->
			<VRow>
				<VCol cols="12" md="8">
					<VCombobox v-model="suratData.penanda_tangan" :items="listPenandaTangan" label="Penanda Tangan" required />
				</VCol>

				<VCol cols="12" md="4">
					<VDateInput v-model="suratData.tanggal_surat" variant="outlined" label="Tanggal Surat" prepend-icon=""
						prepend-inner-icon="$calendar" />
				</VCol>
			</VRow>

			<!-- Nomor surat -->
			<VRow>
				<VCol cols="12">
					<VTextField v-model="suratData.nomor" label="Nomor Surat" required />
				</VCol>
			</VRow>

			<!-- Kalimat pembuka -->
			<VRow>
				<VCol cols="12">
					<h2 class="text-h6">Kalimat Pembuka</h2>
					<div style="min-height: 200px;" class="d-flex flex-column">
						<QuillEditor v-model:content="suratData.kalimat_pembuka" content-type="html"
							placeholder="Kalimat pembuka..." theme="snow" class="flex-fill" toolbar="essential" />
					</div>
				</VCol>
			</VRow>

			<!-- Ditugaskan -->
			<VRow>
				<VCol cols="12">
					<h2 class="text-h6">Orang Yang Ditugaskan</h2>
					<DitugaskanTable :on-add="addDitugaskan" :on-delete="deleteDitugaskan"
						:list-ditugaskan="suratData.ditugaskan" />
				</VCol>
			</VRow>

			<!-- Isi surat -->
			<VRow>
				<VCol cols="12">
					<h2 class="text-h6">Isi Surat</h2>
					<div style="min-height: 200px;" class="d-flex flex-column">
						<QuillEditor v-model:content="suratData.isi_surat" content-type="html" placeholder="Isi surat..."
							theme="snow" class="flex-fill" toolbar="essential" />
					</div>
				</VCol>
			</VRow>

			<!-- Kalimat penutup -->
			<VRow>
				<VCol cols="12">
					<h2 class="text-h6">Kalimat Penutup</h2>
					<div style="min-height: 200px;" class="d-flex flex-column">
						<QuillEditor v-model:content="suratData.kalimat_penutup" content-type="html"
							placeholder="Kalimat penutup..." theme="snow" class="flex-fill" toolbar="essential" />
					</div>
				</VCol>
			</VRow>
		</VCardText>

		<VCardActions>
			<VBtn color="primary" variant="flat" type="submit">Buat</VBtn>
			<VBtn color="primary" variant="outlined">Simpan Ke Draft</VBtn>
			<VBtn color="primary" variant="outlined">Review</VBtn>
			<slot></slot>
		</VCardActions>
	</VForm>
</template>

<style scoped lang="scss">
.fade-overlay {
	background: linear-gradient(to bottom, transparent, rgb(var(--v-theme-surface)) 55%);
	pointer-events: none;
}
</style>
