<script setup lang="ts">
import { onMounted, reactive, ref, watch } from 'vue';

import { QuillEditor } from "@vueup/vue-quill";

import DOMPurify from 'dompurify';
import Swal from 'sweetalert2';
import { convertBlobToBase64, validateFileInput } from '@/utils/file';
import { tantanganValidator } from '../validators/tantangan-validator';
import { DEFAULT_TANTANGAN } from '@/constants';
import debounce from 'just-debounce';
import { mysqlDateTime } from '@/utils/mysql-datetime';

const { tantangan, title, mainActionTitle } = defineProps({
	tantangan: { type: Object },
	title: { type: String },
	mainActionTitle: { type: String },
});

const emit = defineEmits(['createTantangan']);


const descRef = ref(null);
const tantanganData = reactive(tantangan ?? DEFAULT_TANTANGAN);
const previewPicture = ref(tantangan?.gambar ? tantangan.gambar : null);
const isCreatingTantangan = ref(false);

const isFormValid = ref(false);

const revalidateForm = debounce(async () => {
	const rawTantangan = {
		...tantanganData,
		tanggal_mulai: mysqlDateTime(tantanganData.tanggal_mulai),
		tanggal_selesai: mysqlDateTime(tantanganData.tanggal_selesai),
	};

	const { success } = await tantanganValidator.safeParseAsync(rawTantangan);

	isFormValid.value = success;
}, 500);

onMounted(revalidateForm);
watch(tantanganData, revalidateForm, { deep: true });

const resetFormTantangan = () => {
	if (tantangan) {
		previewPicture.value = tantangan.gambar;
		tantanganData.gambar = tantangan.gambar;
		tantanganData.judul = tantangan.judul;
		tantanganData.overview = tantangan.overview;
		tantanganData.deskripsi = tantangan.deskripsi;
		tantanganData.tanggal_mulai = new Date(tantangan.tanggal_mulai);
		tantanganData.tanggal_selesai = new Date(tantangan.tanggal_selesai);
		descRef.value?.setHTML(tantangan.deskripsi);
	} else {
		previewPicture.value = null;
		tantanganData.judul = "";
		tantanganData.overview = "";
		tantanganData.deskripsi = "";
		tantanganData.gambar = null;
		tantanganData.tanggal_mulai = null;
		tantanganData.tanggal_selesai = null;
		descRef.value?.setHTML("");
	}
};

const handleChangeGambar = async file => {
	if (!file) {
		tantanganData.gambar = null;

		return;
	}


	if (
		!validateFileInput(file, "image/jpeg") &&
		!validateFileInput(file, "image/png") &&
		!validateFileInput(file, "image/jpg")
	) {
		await Swal.fire({
			icon: "error",
			text: "File harus berupa gambar dengan tipe jpeg, png, atau jpg.",
			showCloseButton: true,
		});

		return;
	}


	const base64 = await convertBlobToBase64(file);
	const previewBase64 = `data:${file.type};base64,${base64}`;

	tantanganData.gambar = base64;
	previewPicture.value = previewBase64;
};

const emitCreateTantangan = async () => {
	if (!isFormValid.value) {
		await Swal.fire({
			icon: "error",
			text: "Data tantangan tidak valid, silahkan periksa kembali inputan Anda.",
			showCloseButton: true,
		});

		return;
	}

	emit('createTantangan', {
		...tantanganData,
		deskripsi: DOMPurify.sanitize(tantanganData.deskripsi),
	}, isCreatingTantangan, resetFormTantangan);
};

const handleResetForm = async () => {
	const { isConfirmed } = await Swal.fire({
		icon: "warning",
		text: "Apakah Anda yakin ingin mereset form?",
		showCancelButton: true,
		showConfirmButton: true,
	});

	if (isConfirmed) {
		resetFormTantangan();
	}
};

// Resets the end date if the start date is later
watch(() => tantanganData.tanggal_mulai, newValue => {
	if (tantanganData.tanggal_selesai && newValue > tantanganData.tanggal_selesai) {
		tantanganData.tanggal_selesai = null;
	}
});
</script>

<template>
	<VCard tag="form" @submit.prevent="emitCreateTantangan">
		<VCardItem>
			<VCardTitle>{{ title ?? "Form Tantangan" }}</VCardTitle>
		</VCardItem>

		<VCardText>
			<div class="d-flex flex-column gap-4">
				<!-- Judul tantangan -->
				<VTextField v-model="tantanganData.judul" :loading="isCreatingTantangan" label="Judul" required
					prepend-inner-icon="bx-rename" />

				<!-- Overview tantangan -->
				<VTextField v-model="tantanganData.overview" :loading="isCreatingTantangan" label="Penjelasan Singkat Tantangan"
					prepend-inner-icon="bx-text" required />
			</div>

			<!-- Tanggal tantangan -->
			<div class="mt-4 d-flex flex-column flex-md-row gap-4">
				<VDateInput v-model="tantanganData.tanggal_mulai" :loading="isCreatingTantangan" variant="outlined"
					label="Tanggal Mulai Tantangan" prepend-icon="" prepend-inner-icon="$calendar" />
				<VDateInput v-model="tantanganData.tanggal_selesai" :disabled="!tantanganData.tanggal_mulai"
					:min="new Date(new Date(tantanganData.tanggal_mulai).getTime() + 24 * 60 * 60 * 1000)"
					:loading="isCreatingTantangan" variant="outlined" label="Tanggal Selesai Tantangan" prepend-icon=""
					prepend-inner-icon="$calendar" />
			</div>

			<!-- Deskripsi tantangan -->
			<div class="mt-6">
				<h2 class="text-h6 mb-4">Detail Tantangan</h2>
				<div style="min-height: 200px;" class="d-flex flex-column">
					<QuillEditor ref='descRef' v-model:content="tantanganData.deskripsi" :disabled="isCreatingTantangan"
						content-type="html" placeholder="Jelaskan tantangan secara detail..." theme="snow" class="flex-fill"
						toolbar="essential" />
				</div>
			</div>

			<VFileInput :multiple="false" class="mt-4" :loading="isCreatingTantangan" accept=".jpg,.jpeg,.png" prepend-icon=""
				prepend-inner-icon="bx-file" label="Gambar Tantangan" @update:model-value="handleChangeGambar" />


			<div v-if="previewPicture" class="mt-6">
				<h2 class="text-h6 mb-4">Preview Gambar</h2>
				<VImg :src="previewPicture" class=" mx-auto rounded-lg" />
			</div>
		</VCardText>

		<VCardActions class="flex-wrap gap-2">
			<VBtn color="primary" :disabled="!isFormValid" :loading="isCreatingTantangan" variant="flat" type="submit">
				{{ mainActionTitle ?? "Buat Tantangan" }}
			</VBtn>
			<VBtn v-if="!isCreatingTantangan" :loading="isCreatingTantangan" color="error" type="button"
				@click="handleResetForm">
				Reset Form
			</VBtn>

			<slot></slot>
		</VCardActions>

	</VCard>
</template>


<style>
.v-input__details {
	display: none;
}
</style>