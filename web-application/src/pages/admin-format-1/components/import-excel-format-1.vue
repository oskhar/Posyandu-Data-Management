<script setup>
import { api } from '@/lib/api';
import { getSwalErrorMessage } from '@/utils/get-error-message';
import Swal from 'sweetalert2';
import { ref } from 'vue';

const isActive = ref(false);
const isSending = ref(false);
const file = ref(null);

const handleFileChange = incomingFile => {
	file.value = incomingFile
};

const sendExcel = async () => {
	try {
		isSending.value = true;

		if (!file.value) {
			await Swal.fire({
				icon: 'error',
				title: 'Tidak ada file yang dipilih!',
				text: "Mohon pilih file excel yang ingin di import!",
				showCloseButton: true,
			});

			return;
		}

		const { isConfirmed } = await Swal.fire({
			icon: 'question',
			title: 'Konfirmasi Import Data',
			text: "Apakah anda yakin ingin mengimport file excel ini?",
			showCancelButton: true,
			showConfirmButton: true,
		});

		if (isConfirmed) {
			const formData = new FormData();

			formData.append('file', file.value);

			await api.post('/import/format-a', formData, {
				headers: {
					'Content-Type': 'multipart/form-data',
				},
			})

			await Swal.fire({
				icon: 'success',
				title: 'Berhasil import data',
				text: 'Data berhasil diimport!',
				showCloseButton: true,
			})

			file.value = null;
			isActive.value = false;
		}

	} catch (error) {
		await Swal.fire({
			icon: 'error',
			customClass: "excel-error",
			title: 'Terjadi Kesalahan saat import',
			html: getSwalErrorMessage(error),
			showCloseButton: true,
		});
	} finally {
		isSending.value = false;
	}
};
</script>

<template>
	<VBtn prepend-icon="bx-plus" @click="isActive = true">
		Import Data
	</VBtn>

	<VDialog v-model="isActive" persistent max-width="340">
		<template #default>
			<VCard>
				<VCardItem>
					<VCardTitle>Import data</VCardTitle>
				</VCardItem>
				<VCardText>
					<VFileInput :multiple="false" class="mt-4" :loading="isSending" accept=".xls,.xlsx" prepend-icon=""
						prepend-inner-icon="bx-file" label="File Excel" @update:model-value="handleFileChange" />
				</VCardText>
				<template #actions>
					<VBtn :loading="isSending" color="error" text="Close" @click="isActive = false">Cancel
					</VBtn>
					<VBtn :loading="isSending" :disabled="!file" @click="sendExcel">Import</VBtn>
				</template>
			</VCard>
		</template>
	</VDialog>
</template>

<style>
.excel-error {
	min-width: 100%;
}
</style>