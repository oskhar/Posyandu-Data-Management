<script setup>
const { namaLengkapKetua, sambutanKetua, fotoProfileKetua, jabatanKetua } = defineProps({
	namaLengkapKetua: { type: String, required: true },
	sambutanKetua: { type: String, required: true },
	fotoProfileKetua: { type: String, required: true },
	jabatanKetua: { type: String, required: true },
})
</script>

<template>
	<VRow tag="section" class="px-5">
		<VCol cols="12" md="9" class="mx-auto">
			<VRow>
				<VCol md="7" cols="12" class='d-flex flex-column justify-center'>
					<h2 class="text-h4 font-weight-bold text-primary mb-5">
						Sambutan Ketua Posyandu
					</h2>

					<p class="text-subtitle-1">
						{{ sambutanKetua }}
					</p>

					<p class="text-high-emphasis font-italic mt-4"> - {{ namaLengkapKetua }}, <span
							style="text-transform: capitalize;">{{
								jabatanKetua.toLowerCase() }}</span>
					</p>

				</VCol>

				<VCol cols="12" md="5">
					<VImg class="mx-auto d-block rounded-xl elevation-10" :src="fotoProfileKetua" :alt="namaLengkapKetua" />
				</VCol>
			</VRow>
		</VCol>
	</VRow>
</template>