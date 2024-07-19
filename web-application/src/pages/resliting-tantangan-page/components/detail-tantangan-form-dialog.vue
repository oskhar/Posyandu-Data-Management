<script setup>
import { convertBlobToBase64, validateFileInput } from '@/utils/file';
import { getErrorMessage } from '@/utils/get-error-message';
import Swal from 'sweetalert2';
import { computed, ref } from 'vue';
import z from 'zod';
import { sendSubmissionTantangan } from '../api/resliting-tantangan-page-api';


const { activator, tantanganId } = defineProps({
	activator: { type: String, required: true },
	tantanganId: { type: String, required: true },
})


const submissionValidator = z.object({
	file: z.string().trim().nullable(),
	link: z.string().trim().nullable(),
}).refine(data => data.file !== null || data.link !== null, {
	message: "File atau link, salah satunya harus diisi!",
	path: ['file', 'link'],
});

const isRawForminValid = computed(() => form.value.file === null && form.value.link === null)


const isSubmitting = ref(false);
const hasSubmitted = ref(false);
const form = ref({ file: null, link: null })

const handleSubmit = async () => {
	try {
		if (hasSubmitted.value) {
			throw new Error("Anda sudah mengumpulkan data!");
		}

		isSubmitting.value = true;

		const { isConfirmed } = await Swal.fire({
			icon: "warning",
			text: "Apakah anda yakin ingin mengumpulkan data?",
			showCancelButton: true,
			showConfirmButton: true,
		});

		if (!isConfirmed) {
			return;
		}

		if (isRawForminValid.value) {
			throw new Error("File atau link, salah satunya harus diisi!");
		}

		if (!validateFileInput(form.value.file, "application/zip", 10 * 1024 * 1024)) {
			throw new Error("File bukan berekstensi .zip atau ukuran file lebih dari 10MB!");
		}


		const formWithBase64File = {
			...form.value,
			file: await convertBlobToBase64(form.value.file),
		};

		const data = await submissionValidator.parseAsync(formWithBase64File);

		console.log(tantanganId);
		await sendSubmissionTantangan({ tantangan_id: tantanganId, ...data });

		await Swal.fire({
			icon: "success",
			text: "Data berhasil dikumpulkan!",
			showCloseButton: true,
		});

		hasSubmitted.value = true;
	} catch (error) {
		await Swal.fire({
			icon: "error",
			text: getErrorMessage(error, "Terjadi kesalahan saat mengumpulkan data!"),
			showCloseButton: true,
		});
	} finally {
		isSubmitting.value = false;
	}
}
</script>


<template>
	<VDialog persistent :activator='activator' max-width="640">
		<template #default="{ isActive }">
			<VCard tag="form" @submit.prevent="handleSubmit">
				<VCardItem>
					<VCardTitle>Form Submission</VCardTitle>
					<p v-if="!hasSubmitted" class="text-subtitle-2">Silahkan isi salah satu, isi input file atau link untuk
						melakukan pengumpulan dan mengikuti tantangan. <span class="font-weight-bold text-primary">Submission hanya
							bisa dilakukan sekali!</span>
					</p>
					<p v-else class="text-subtitle-2">
						Anda sudah mengumpulkan submission ke tantangan ini!
					</p>
				</VCardItem>

				<VCardText class="mt-4">
					<div class="d-flex flex-column gap-4">
						<VFileInput v-model="form.file" :disabled="hasSubmitted" :loading="isSubmitting" accept=".zip"
							prepend-icon="" prepend-inner-icon="bx-file" label="Input File (Format .zip & Maks. 10MB)" />
						<VTextField v-model="form.link" :disabled="hasSubmitted" :loading="isSubmitting"
							label="Link (Isi link jika ukuran file >10MB)" prepend-inner-icon="bx-link" />
					</div>
				</VCardText>

				<VCardActions>
					<VBtn v-if="!isSubmitting" color="error" @click="isActive.value = false">Close</VBtn>
					<VBtn :disabled="hasSubmitted || isRawForminValid" :loading="isSubmitting" type="submit">Kirim</VBtn>
				</VCardActions>
			</VCard>
		</template>
	</VDialog>
</template>