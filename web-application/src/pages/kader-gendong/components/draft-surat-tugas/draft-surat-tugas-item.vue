<script setup>
import { nextTick, ref } from 'vue';
import FormSuratTugas from '../form-surat-tugas.vue';

const { draft } = defineProps({
	draft: { type: Object, required: true },
});

const emit = defineEmits(['deleteDraft', 'editDraft']);


const isDeletingDraft = ref(false);

const emitDeleteDraftSuratTugas = async id => {
	isDeletingDraft.value = true;
	emit('deleteDraft', id);

	await nextTick()
	isDeletingDraft.value = false;
};

const isEditingDraft = ref(false);

const emitEditDraftSuratTugas = async draft => {
	isEditingDraft.value = true;
	emit('editDraft', draft);

	await nextTick()

	isEditingDraft.value = false;
};


const isDialogActive = ref(false);
</script>

<template>
	<VCard style="height: 312px;" class="cursor-pointer" @click="isDialogActive = true">
		<VCardItem class="border-b-md pb-3">
			<p class="text-subtitle-1 mb-1 font-black">No. Surat: {{ draft.nomor }}</p>
			<p class="text-subtitle-2 mb-1 font-black">Penanda Tangan: {{ draft.penanda_tangan }}</p>
			<p class="text-subtitle-2 mb-1 font-black">Tanggal Surat: {{ new Date(draft.tanggal_surat).toLocaleDateString() }}
			</p>
		</VCardItem>
		<VCardText class="position-relative text-justify mt-2">
			<p class="text-subtitle-1 mb-0">Isi Surat:</p>
			<div class="text-subtitle-2" v-html="draft.isi_surat" />
			<div class="fade-overlay position-absolute h-100 left-0 right-0 bottom-0" />
		</VCardText>
	</VCard>

	<VDialog v-model="isDialogActive" max-width="1024" persistent>
		<template #default="{ isActive }">
			<VCard prepend-icon="bx-file" title="Edit Draft">
				<FormSuratTugas :surat="draft" @create-draft="emitEditDraftSuratTugas">
					<VBtn :disabled="isDeletingDraft" variant="outlined" color="error" style="margin: 0 !important;"
						@click="emitDeleteDraftSuratTugas(draft.id)">Hapus Draft</VBtn>
					<VBtn :disabled="isEditingDraft" class="ml-auto" color="error" @click="isActive.value = false">Cancel</VBtn>
				</FormSuratTugas>
			</VCard>
		</template>
	</VDialog>
</template>

<style lang="scss" scoped>
.fade-overlay {
	background: linear-gradient(to bottom, transparent, rgb(var(--v-theme-surface)) 55%);
	pointer-events: none;
}
</style>
