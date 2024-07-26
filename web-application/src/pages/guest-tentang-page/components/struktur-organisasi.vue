<script setup>
const { fotoStrukturOrganisasi } = defineProps({
	fotoStrukturOrganisasi: { type: String, required: true },
})
</script>

<template>
	<VRow tag="section" class="px-5">
		<VCol cols="12" md="9" class="mx-auto">
			<VRow>
				<VCol cols="12" class="text-center">
					<h2 class="text-h5 font-weight-bold text-primary">Struktur Organisasi</h2>
					<p class="text-secondary text-subtitle-1">
						Struktur organisasi dari Posyandu Melati IX RW 09
					</p>
				</VCol>
				<VCol cols="12">
					<VImg :src="fotoStrukturOrganisasi" max-width="700" rounded class="mx-auto elevation-10" />
				</VCol>
			</VRow>
		</VCol>
	</VRow>
</template>