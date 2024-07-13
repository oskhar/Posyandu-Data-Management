<script setup>
const { namaLengkapKetua, sambutanKetua, fotoProfileKetua, jabatanKetua } = defineProps({
	namaLengkapKetua: { type: String, required: true },
	sambutanKetua: { type: String, required: true },
	fotoProfileKetua: { type: String, required: true },
	jabatanKetua: { type: String, required: true },
})

console.log(sambutanKetua);
</script>

<template>
	<VRow tag="section" class="px-5">
		<VCol cols="12" md="9" class="mx-auto">
			<VRow>
				<VCol md="8" cols="12">
					<h2 class="text-h5 font-weight-bold text-primary mb-5">
						Sambutan Ketua Posyandu
					</h2>

					<p style="white-space: pre-line;">
						{{ sambutanKetua }}
					</p>
				</VCol>

				<VCol cols="12" md="4" sm="12">
					<VCard class="pt-5">
						<VCardItem>
							<img style="width: 250px; height: 250px; object-fit: cover; border-radius: 4px;" class="mx-auto d-block"
								:src="fotoProfileKetua" :alt="namaLengkapKetua" />

							<div class="text-center mt-3">
								<p class="text-h5 font-weight-bold">{{ namaLengkapKetua }}</p>
								<p>{{ jabatanKetua }}</p>
							</div>
						</VCardItem>
					</VCard>
				</VCol>
			</VRow>
		</VCol>
	</VRow>
</template>