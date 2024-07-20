<script setup>
import { QuillEditor } from "@vueup/vue-quill"
import { onMounted, reactive, ref } from 'vue';
import DOMPurify from 'dompurify';
import DitugaskanTable from "./buat-surat-tugas/ditugaskan-table.vue";
import PreviewSuratTugas from "./preview-surat-tugas.vue";
import { pdfBase64 } from "@/utils/file";
import { previewSuratTugas } from "../api/surat-tugas-api";
import Swal from "sweetalert2";
import { getSwalErrorMessage } from "@/utils/get-error-message";
import { DEFAULT_SURAT } from "@/constants";
import { suratTugasValidator } from "../validators/surat-tugas-validator";
import debounce from "just-debounce";
import { mysqlDateTime } from "@/utils/mysql-datetime";

const { surat } = defineProps({ surat: { type: Object } });
const emit = defineEmits(['create', "createDraft"]);

const kalimatPembukaRef = ref(null);
const isiSuratRef = ref(null);
const kalimatPenutupRef = ref(null);

const suratData = reactive(surat ?? DEFAULT_SURAT);

const previewSuratTugasBase64 = ref(null);
const isPreviewSuratActive = ref(false);
const isPreviewSuratLoading = ref(false);

const isCreatingSuratTugas = ref(false);
const isCreatingDraftSuratTugas = ref(false);
const isFormValid = ref(false);

const revalidateForm = debounce(async () => {
	const rawSuratData = {
		...suratData,
		tanggal_surat: mysqlDateTime(new Date(suratData.tanggal_surat)),
	};

	const { success, error } = await suratTugasValidator.safeParseAsync(rawSuratData);

	isFormValid.value = success;
}, 500);

onMounted(revalidateForm)
watch(suratData, revalidateForm, { deep: true });

const openPreviewSuratTugas = async () => {
	try {
		isPreviewSuratLoading.value = true;

		const file = await previewSuratTugas(suratData);

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
	if (surat) {
		suratData.penanda_tangan = surat.penanda_tangan;
		suratData.tanggal_surat = new Date(surat.tanggal_surat);
		suratData.jabatan_penanda_tangan = surat.jabatan_penanda_tangan;
		suratData.nomor = surat.nomor;
		suratData.kalimat_pembuka = surat.kalimat_pembuka;
		suratData.ditugaskan = surat.ditugaskan;
		suratData.isi_surat = surat.isi_surat;
		suratData.kalimat_penutup = surat.kalimat_penutup;


		kalimatPembukaRef.value?.setHTML(surat.kalimat_pembuka);
		isiSuratRef.value?.setHTML(surat.isi_surat);
		kalimatPenutupRef.value?.setHTML(surat.kalimat_penutup);
	} else {
		suratData.penanda_tangan = "";
		suratData.tanggal_surat = null;
		suratData.jabatan_penanda_tangan = "";
		suratData.nomor = "";
		suratData.kalimat_pembuka = '';
		suratData.ditugaskan = [];
		suratData.isi_surat = '';
		suratData.kalimat_penutup = '';

		kalimatPembukaRef.value?.setHTML("");
		isiSuratRef.value?.setHTML("");
		kalimatPenutupRef.value?.setHTML("");
	}
};

const handleResetForm = async () => {
	const { isConfirmed } = await Swal.fire({
		title: "Reset Form",
		text: "Apakah Anda ingin mereset form surat?",
		icon: "question",
		showCancelButton: true,
		showConfirmButton: true,
	});

	if (isConfirmed) {
		resetFormSuratTugas();
	}
}

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
						<QuillEditor ref="kalimatPembukaRef" v-model:content="suratData.kalimat_pembuka" content-type="html"
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
						<QuillEditor ref="isiSuratRef" v-model:content="suratData.isi_surat" content-type="html"
							placeholder="Isi surat..." theme="snow" class="flex-fill" toolbar="essential" />
					</div>
				</VCol>
			</VRow>

			<!-- Kalimat penutup -->
			<VRow>
				<VCol cols="12">
					<h2 class="text-h6">Kalimat Penutup</h2>
					<div style="min-height: 200px;" class="d-flex flex-column">
						<QuillEditor ref="kalimatPenutupRef" v-model:content="suratData.kalimat_penutup" content-type="html"
							placeholder="Kalimat penutup..." theme="snow" class="flex-fill" toolbar="essential" />
					</div>
				</VCol>
			</VRow>
		</VCardText>

		<VCardActions class="flex-wrap gap-2">
			<VBtn :disabled="!isFormValid" color="primary" :loading="isCreatingSuratTugas || isPreviewSuratLoading"
				variant="flat" type="button" @click="emitCreateSuratTugas">
				Buat Surat
			</VBtn>

			<VBtn :disabled="!isFormValid" color="primary" :loading="isCreatingDraftSuratTugas || isPreviewSuratLoading"
				variant="outlined" type="button" @click="emitCreateDraftSuratTugas">
				Simpan Ke Draft
			</VBtn>



			<VBtn :disabled="!isFormValid" :loading="isCreatingSuratTugas || isPreviewSuratLoading" color="primary"
				variant="outlined" @click="openPreviewSuratTugas">
				Review
			</VBtn>

			<VBtn :loading="isCreatingSuratTugas || isPreviewSuratLoading" color="error" variant="outlined"
				@click="handleResetForm">
				Reset
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
