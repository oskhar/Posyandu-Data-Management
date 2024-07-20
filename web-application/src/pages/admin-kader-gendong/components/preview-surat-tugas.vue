<!-- PreviewSuratTugas.vue -->
<script setup>
import { toRefs } from 'vue';

const props = defineProps({
	isDialogActive: { type: Boolean, required: true },
	base64Surat: { type: String, required: true },
});

const emit = defineEmits(['update:isDialogActive']);

const closeDialog = () => {
	emit('update:isDialogActive', false);
};
</script>

<template>
	<VDialog :model-value="isDialogActive" max-width="1024" persistent
		@update:model-value="$emit('update:isDialogActive', $event)">
		<VCard prepend-icon="bx-file" title="Preview Surat">
			<VCardText>
				<iframe class="rounded mt-2 border-0" width="100%" height="500px" :src="base64Surat" />
			</VCardText>
			<VCardActions>
				<VBtn class="ml-auto" color="error" @click="closeDialog">Tutup</VBtn>
				<slot></slot>
			</VCardActions>
		</VCard>
	</VDialog>
</template>
