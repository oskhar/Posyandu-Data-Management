<script setup>
import Swal from "sweetalert2";
import { reactive, ref } from "vue";
import { VTextarea } from "vuetify/lib/components/index.mjs";
import { editFeedback } from "../../api/submissions-api";
import { getSwalErrorMessage } from "@/utils/get-error-message";

const { submission } = defineProps({
	tantanganId: { type: String, required: true },
	submission: { type: Object, required: true },
});

const emit = defineEmits(['updateSubmission']);

const isDialogActive = ref(false);

const form = reactive({
	feedback: "",
	juara: null,
});

const handleSaveChanges = async () => {
	try {
		const { isConfirmed } = await Swal.fire({
			title: 'Simpan Perubahan',
			text: 'Apakah Anda yakin ingin menyimpan feedback?',
			icon: 'question',
			showCancelButton: true,
			showConfirmButton: true,
		});

		if (isConfirmed) {
			await editFeedback(submission.id, {
				feedback: form.feedback,
				peringkat: form.juara,
			});

			await Swal.fire({
				icon: 'success',
				title: 'Berhasil menyimpan feedback',
			});

			emit('updateSubmission')
		}
	} catch (error) {
		await Swal.fire({
			icon: 'error',
			title: 'Gagal menyimpan feedback',
			html: getSwalErrorMessage(error, 'Gagal menyimpan feedback!'),
		})
	}
}
</script>

<template>
	<VBtn prepend-icon="bx-pencil" @click="isDialogActive = !isDialogActive">Beri Feedback</VBtn>

	<VDialog v-model="isDialogActive" max-width="640" persistent>
		<template #default="{ isActive }">
			<VCard prepend-icon="bx-file" title="Beri Feedback Submission">
				<VCardText class="mt-6 d-flex flex-column gap-4">
					<VNumberInput v-model="form.juara" color="primary" variant="outlined" control-variant="stacked"
						label='Juara (1 - 3)' :min="1" :max="3" />
					<VTextarea v-model="form.feedback" label="Feedback" placeholder="Masukkan feedback anda" />
				</VCardText>

				<VCardActions>
					<VBtn :loading="isEditingDraft" color="error" @click="isActive.value = false">Cancel</VBtn>
					<VBtn :loading="isEditingDraft" color="primary" @click="handleSaveChanges">Simpan</VBtn>
				</VCardActions>
			</VCard>
		</template>
	</VDialog>
</template>