<script setup lang="ts">
import { nextTick, onMounted, reactive, ref, watch } from 'vue';

import { QuillEditor } from "@vueup/vue-quill";

import DOMPurify from 'dompurify';
import Swal from 'sweetalert2';
import { convertBase64ToDataUri, convertBlobToBase64, validateFileInput } from '@/utils/file';
import { produkValidator } from '../validators/produk-validator';
import { DEFAULT_PRODUK } from '@/constants';
import { getTags } from '../api/produk-api';
import { VTextField } from 'vuetify/lib/components/index.mjs';
import debounce from 'just-debounce';

const { produk, title, mainActionTitle } = defineProps({
	produk: { type: Object },
	title: { type: String },
	mainActionTitle: { type: String },
});

const emit = defineEmits(['createProduk']);

const availableTags = ref([]);
const produkData = reactive({ ...(produk ?? DEFAULT_PRODUK) });
const descRef = ref(null);
const previewPicture = ref(produk?.gambar ? produk.gambar : null);
const isCreatingProduk = ref(false);
const isFormValid = ref(false);

const revalidateForm = debounce(async () => {
	const { success, error } = await produkValidator.safeParseAsync(produkData);

	console.log("🚀 ~ revalidateForm ~ error:", error);

	isFormValid.value = success;
}, 500);

watch(produkData, revalidateForm, { deep: true });

watch(() => produk, newProduk => {
	Object.assign(produkData, newProduk ?? DEFAULT_PRODUK);
	previewPicture.value = newProduk?.gambar || null;
}, { immediate: true, deep: true });

const resetFormProduk = () => {
	if (produk) {
		previewPicture.value = produk.gambar;
		produkData.nomor_telepon = produk.nomor_telepon;
		produkData.nama = produk.nama;
		produkData.deskripsi = produk.deskripsi;
		produkData.overview = produk.overview;
		produkData.tags = produk.tags;
		produkData.harga = produk.harga;
		produkData.gambar = produk.gambar;
		produkData.sedang_dijual = produk.sedang_dijual;
		produkData.pin = produk.pin;
		descRef.value?.setHTML(produk.deskripsi);
	} else {
		previewPicture.value = null;
		produkData.nomor_telepon = null;
		produkData.nama = null;
		produkData.deskripsi = null;
		produkData.overview = null;
		produkData.tags = [];
		produkData.harga = 0;
		produkData.gambar = null;
		produkData.sedang_dijual = false;
		produkData.pin = false;
		descRef.value?.setHTML("");
	}

};

const handleChangeGambar = async file => {
	if (!file) {
		produkData.gambar = null;

		return;
	}

	if (!validateFileInput(file, "image/jpeg") && !validateFileInput(file, "image/png") && !validateFileInput(file, "image/jpg")) {
		await Swal.fire({
			icon: "error",
			text: "File harus berupa gambar dengan tipe jpeg, png, atau jpg.",
			showCloseButton: true,
		});

		return;
	}

	const base64 = await convertBlobToBase64(file);
	const previewBase64 = convertBase64ToDataUri(base64, file.type);

	produkData.gambar = base64;
	previewPicture.value = previewBase64;
};

const emitCreateProduk = async () => {
	if (!isFormValid.value) {
		await Swal.fire({
			icon: "error",
			text: "Data produk tidak valid, silahkan periksa kembali inputan Anda.",
			showCloseButton: true,
		});

		return;
	}

	emit('createProduk', {
		...produkData,
		deskripsi: DOMPurify.sanitize(produkData.deskripsi),
	}, isCreatingProduk, resetFormProduk);
};

const handleResetForm = async () => {
	const { isConfirmed } = await Swal.fire({
		icon: "warning",
		text: "Apakah Anda yakin ingin mereset form?",
		showCancelButton: true,
		showConfirmButton: true,
	});

	if (isConfirmed) {
		resetFormProduk();
	}
};

onMounted(async () => {
	availableTags.value = await getTags();
});
</script>

<template>
	<VCard tag="form" @submit.prevent="emitCreateProduk">
		<VCardItem>
			<VCardTitle>{{ title ?? "Form Produk" }}</VCardTitle>
		</VCardItem>

		<VCardText>
			<div class="d-flex flex-column gap-4">
				<!-- Nama dan harga produk -->
				<div class="d-flex flex-column flex-md-row gap-4">
					<!-- Nama produk -->
					<VTextField v-model="produkData.nama" :loading="isCreatingProduk" label="Nama"
						prepend-inner-icon="bx-rename" />

					<!-- harga produk -->
					<VNumberInput v-model="produkData.harga" control-variant="stacked" label="Harga (Rp)" variant="outlined"
						color="primary" :loading="isCreatingProduk" prepend-inner-icon="bx-money">
					</VNumberInput>
				</div>

				<!-- No.Telepon penjual produk -->
				<VTextField v-model="produkData.nomor_telepon" :loading="isCreatingProduk" label="Nomor Whatsapp Penjual"
					prepend-inner-icon="bx-phone" />

				<!-- Overview produk -->
				<VTextField v-model="produkData.overview" :loading="isCreatingProduk" label="Penjelasan Singkat Produk"
					prepend-inner-icon="bx-text" />

				<!-- Tags Produk  -->
				<VCombobox v-model="produkData.tags" prepend-inner-icon="bx-purchase-tag" label="Tag Produk" chips multiple
					:items="availableTags">
				</VCombobox>
			</div>

			<!-- Deskripsi produk -->
			<div class="mt-6">
				<h2 class="text-h6 mb-4">Detail Produk</h2>
				<div style="min-height: 200px;" class="d-flex flex-column">
					<QuillEditor ref='descRef' v-model:content="produkData.deskripsi" :disabled="isCreatingProduk"
						content-type="html" placeholder="Jelaskan produk secara detail..." theme="snow" class="flex-fill"
						toolbar="essential" />
				</div>
			</div>

			<VFileInput :multiple="false" class="mt-4" :loading="isCreatingProduk" accept=".jpg,.jpeg,.png" prepend-icon=""
				prepend-inner-icon="bx-image-alt" label="Gambar Produk" @update:model-value="handleChangeGambar" />

			<div v-if="previewPicture" class="mt-6">
				<h2 class="text-h6 mb-4">Preview Gambar</h2>
				<VImg :src="previewPicture" class=" mx-auto rounded-lg" />
			</div>

			<!-- Status produk -->
			<h2 class="text-h6 mb-4 mt-8">Status Produk</h2>
			<div class="d-flex flex-column gap-6">
				<div class="d-flex justify-space-between flex-column flex-md-row align-md-center">
					<div class="d-flex flex-column gap-2">
						<p class="mb-0 font-weight-bold">Pin Produk</p>
						<p>Produk ini akan tampil di banner halaman pencarian produk di sisi user. <i>(Maks. 5 produk)</i></p>
					</div>
					<VSwitch v-model="produkData.pin" inset />
				</div>

				<div class="d-flex justify-space-between flex-column flex-md-row align-md-center">
					<div class="d-flex flex-column gap-2">
						<p class="mb-0 font-weight-bold">Produk Dijual</p>
						<p>Produk akan tampil pada halaman pencarian dan akan disembunyikan jika sedang tidak dijual.</p>
					</div>
					<VSwitch v-model="produkData.sedang_dijual" inset />
				</div>
			</div>
		</VCardText>

		<VCardActions class="flex-wrap gap-2">
			<VBtn color="primary" :disabled="!isFormValid" :loading="isCreatingProduk" variant="flat" type="submit">
				{{ mainActionTitle ?? "Buat Produk" }}
			</VBtn>
			<VBtn v-if="!isCreatingProduk" :loading="isCreatingProduk" color="error" type="button" @click="handleResetForm">
				Reset Form
			</VBtn>

			<slot></slot>
		</VCardActions>
	</VCard>
</template>



<style>
.v-number-input__control {
	display: none;
}

.v-input__details {
	display: none;
}
</style>