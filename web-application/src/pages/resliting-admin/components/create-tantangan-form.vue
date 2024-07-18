<script setup lang="ts">
import { computed, reactive, ref, watch } from 'vue';

import { QuillEditor } from "@vueup/vue-quill";

import DOMPurify from 'dompurify';
import Swal from 'sweetalert2';
import { convertBlobToBase64, validateFileInput } from '@/utils/file';
import { tantanganValidator } from '../validators/tantangan-validator';
import { mysqlDateTime } from '@/utils/mysql-datetime';
import { DEFAULT_TANTANGAN } from '@/constants';

const { tantangan } = defineProps({ tantangan: { type: Object }, title: { type: String } });

const emit = defineEmits(['createTantangan']);


const tantanganData = ref({ ...tantangan } ?? DEFAULT_TANTANGAN);
const previewPicture = ref(tantangan?.gambar ? tantangan.gambar : null);
const isCreatingTantangan = ref(false);

const isFormValid = computed(() => {
	const rawTantangan = {
		...tantanganData,
		tanggal_mulai: mysqlDateTime(tantanganData.value.tanggal_mulai),
		tanggal_selesai: mysqlDateTime(tantanganData.value.tanggal_selesai),
	};

	const { success } = tantanganValidator.safeParse(rawTantangan);


	return success;
});

const resetFormTantangan = () => {
	if (tantangan) {
		previewPicture.value = tantangan.gambar;
		tantanganData.value.gambar = tantangan.gambar;
		tantanganData.value.judul = tantangan.judul;
		tantanganData.value.overview = tantangan.overview;
		tantanganData.value.deskripsi = tantangan.deskripsi;
		tantanganData.value.tanggal_mulai = new Date(tantangan.tanggal_mulai);
		tantanganData.value.tanggal_selesai = new Date(tantangan.tanggal_selesai);
	} else {
		previewPicture.value = null;
		tantanganData.value.judul = "";
		tantanganData.value.overview = "";
		tantanganData.value.deskripsi = "";
		tantanganData.value.gambar = null;
		tantanganData.value.tanggal_mulai = null;
		tantanganData.value.tanggal_selesai = null;
	}
};

const handleChangeGambar = async file => {
	if (!file) {
		tantanganData.value.gambar = null;

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

	tantanganData.value.gambar = base64;
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
		deskripsi: DOMPurify.sanitize(tantanganData.value.deskripsi),
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
watch(() => tantanganData.value.tanggal_mulai, newValue => {
	if (tantanganData.value.tanggal_selesai && newValue > tantanganData.value.tanggal_selesai) {
		tantanganData.value.tanggal_selesai = null;
	}
});
</script>

<template>
	<VCard tag="form">
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
					<QuillEditor v-model:content="tantanganData.deskripsi" :disabled="isCreatingTantangan" content-type="html"
						placeholder="Jelaskan tantangan secara detail..." theme="snow" class="flex-fill" toolbar="essential" />
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
			<VBtn color="primary" :disabled="!isFormValid" :loading="isCreatingTantangan" variant="flat" type="button"
				@click="emitCreateTantangan">
				Buat Tantangan
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