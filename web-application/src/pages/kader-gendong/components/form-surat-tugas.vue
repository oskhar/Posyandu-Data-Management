<script setup>
import { QuillEditor } from "@vueup/vue-quill"
import { reactive, ref } from 'vue';
import DOMPurify from 'dompurify';
import DitugaskanTable from "./buat-surat-tugas/ditugaskan-table.vue";
import PreviewSuratTugas from "./preview-surat-tugas.vue";
import { pdfBase64 } from "@/utils/file";
import { previewSuratTugas } from "../api/surat-tugas-api";
import Swal from "sweetalert2";
import { getSwalErrorMessage } from "@/utils/get-error-message";

const { surat } = defineProps({ surat: { type: Object } });
const emit = defineEmits(['create', "createDraft"]);

const isCreatingSuratTugas = ref(false);
const isCreatingDraftSuratTugas = ref(false);

const suratData = reactive(surat ?? {
	penanda_tangan: "",
	tanggal_surat: null,
	jabatan_penanda_tangan: "",
	nomor: "",
	kalimat_pembuka: '',
	ditugaskan: [],
	isi_surat: '',
	kalimat_penutup: '',
});

const previewSuratTugasBase64 = ref(null);
const isPreviewSuratActive = ref(false);
const isPreviewSuratLoading = ref(false);

const openPreviewSuratTugas = async () => {
	try {
		isPreviewSuratLoading.value = true;

		const file = await previewSuratTugas(suratData);

		console.log("🚀 ~ openPreviewSuratTugas ~ file:", file)

		previewSuratTugasBase64.value = file;
		isPreviewSuratActive.value = true;
	} catch (error) {
		previewSuratTugasBase64.value = null;
		isPreviewSuratActive.value = false;

		await Swal.fire({
			icon: "error",
			title: "Gagal Membuka Preview Surat",
			html: getSwalErrorMessage(error),
		});
	} finally {
		isPreviewSuratLoading.value = false;
	}
}

const closePreviewSuratTugas = isActive => {
	isPreviewSuratActive.value = isActive;
	previewSuratTugasBase64.value = null;
}

const addDitugaskan = orang => {
	suratData.ditugaskan.push(orang);
}

const deleteDitugaskan = index => {
	suratData.ditugaskan = suratData.ditugaskan.filter((_, i) => i !== index);
};

const resetFormSuratTugas = () => {
	suratData.penanda_tangan = "";
	suratData.tanggal_surat = null;
	suratData.jabatan_penanda_tangan = "";
	suratData.nomor = "";
	suratData.kalimat_pembuka = '';
	suratData.ditugaskan = [];
	suratData.isi_surat = '';
	suratData.kalimat_penutup = '';
};

const emitCreateSuratTugas = async () => {
	emit('create', {
		...suratData,
		kalimat_pembuka: DOMPurify.sanitize(suratData.kalimat_pembuka),
		isi_surat: DOMPurify.sanitize(suratData.isi_surat),
		kalimat_penutup: DOMPurify.sanitize(suratData.kalimat_penutup),
	}, isCreatingSuratTugas, resetFormSuratTugas);
};

const emitCreateDraftSuratTugas = async () => {
	emit("createDraft", {
		...suratData,
		kalimat_pembuka: DOMPurify.sanitize(suratData.kalimat_pembuka),
		isi_surat: DOMPurify.sanitize(suratData.isi_surat),
		kalimat_penutup: DOMPurify.sanitize(suratData.kalimat_penutup),
	}, isCreatingDraftSuratTugas, resetFormSuratTugas);
}
</script>

<template>
	<VForm>
		<VCardItem>
			<VCardTitle>Form Surat Tugas Posyandu</VCardTitle>
		</VCardItem>

		<VCardText>
			<!-- Penanda tangan, jabatan, dan tanggal surat -->
			<VRow>
				<VCol cols="12" lg="4">
					<VTextField v-model="suratData.penanda_tangan" label="Penanda Tangan" prepend-inner-icon="bx-user" required />
				</VCol>

				<VCol cols="12" md="6" lg="4">
					<VTextField v-model="suratData.jabatan_penanda_tangan" label="Jabatan" prepend-inner-icon="bx-user-pin"
						required />
				</VCol>

				<VCol cols="12" md="6" lg="4">
					<VDateInput v-model="suratData.tanggal_surat" variant="outlined" label="Tanggal Surat" prepend-icon=""
						prepend-inner-icon="$calendar" />
				</VCol>
			</VRow>

			<!-- Nomor surat -->
			<VRow>
				<VCol cols="12">
					<VTextField v-model="suratData.nomor" label="Nomor Surat" prepend-inner-icon="bx-file" required />
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
					<DitugaskanTable :list-ditugaskan="suratData.ditugaskan ?? []" @delete-from-table="deleteDitugaskan"
						@add-to-table="addDitugaskan" />
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

		<VCardActions class="flex-wrap gap-2">
			<VBtn color="primary" :loading="isCreatingSuratTugas" variant="flat" type="button" @click="emitCreateSuratTugas">
				Buat Surat
			</VBtn>

			<VBtn color="primary" :loading="isCreatingDraftSuratTugas" variant="outlined" type="button"
				@click="emitCreateDraftSuratTugas">
				Simpan Ke Draft
			</VBtn>

			<VBtn :loading="isPreviewSuratLoading" color="primary" variant="outlined" @click="openPreviewSuratTugas">
				Review
			</VBtn>

			<slot></slot>

			<PreviewSuratTugas :is-dialog-active="isPreviewSuratActive" :base64-surat="pdfBase64
				(previewSuratTugasBase64)" @update:is-dialog-active="closePreviewSuratTugas" />
		</VCardActions>
	</VForm>
</template>

<style scoped lang="scss">
.fade-overlay {
	background: linear-gradient(to bottom, transparent, rgb(var(--v-theme-surface)) 55%);
	pointer-events: none;
}

.v-card-actions .v-btn~.v-btn:not(.v-btn-toggle .v-btn) {
	margin-inline-start: 0;
}
</style>
