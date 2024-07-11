<script setup>
import { computed } from 'vue';

const { surat } = defineProps({
	surat: { type: Object, required: true },
});


const dialogActivator = computed(() => `surat-${surat.id}`)
</script>

<template>
	<VCard :id="dialogActivator" style="height: 312px;" class="cursor-pointer">
		<VCardItem class="border-b-md pb-3">
			<p class="text-subtitle-1 mb-1 font-black">No. Surat: {{ surat.nomor }}</p>
			<p class="text-subtitle-2 mb-1 font-black">Penanda Tangan: {{ surat.penanda_tangan }}</p>
			<p class="text-subtitle-2 mb-1 font-black">Tanggal Surat: {{ new Date(surat.tanggal_surat).toLocaleDateString() }}
			</p>
		</VCardItem>
		<VCardText class="position-relative text-justify mt-2">
			<p class="text-subtitle-1 mb-0">Isi Surat:</p>
			<div class="text-subtitle-2" v-html="surat.isi_surat" />
			<div class="fade-overlay position-absolute h-100 left-0 right-0 bottom-0" />
		</VCardText>
	</VCard>

	<VDialog :activator="`#${dialogActivator}`" max-width="1024" persistent>
		<template #default="{ isActive }">
			<VCard prepend-icon="bx-file" title="Preview Surat">
				<VCardText>
					<iframe class="rounded mt-2 border-0" width="100%" height="500px" src="http://localhost:5173/README.pdf" />
				</VCardText>
				<VCardActions>
					<VBtn class="ml-auto" color="error" @click="isActive.value = false">Tutup</VBtn>
				</VCardActions>
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
