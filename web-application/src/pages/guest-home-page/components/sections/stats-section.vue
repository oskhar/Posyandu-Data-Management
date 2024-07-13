<script setup>
const { statsBerita, statsEdukasi, statsBayi, statsGambar } = defineProps({
	statsBerita: { type: Number, required: true },
	statsEdukasi: { type: Number, required: true },
	statsGambar: { type: Number, required: true },
	statsBayi: { type: Number, required: true },
})
</script>

<template>
	<VRow tag="section" class="px-5">
		<VCol cols="12" md="9" class="mx-auto">
			<VCard>
				<VCardItem>
					<VRow class="text-center">
						<VCol cols="12" sm="6" lg="3">
							<h1 class="text-primary">
								<VIcon>bx-news</VIcon>
							</h1>
							<h2 class="mb-1 text-h5 text-no-wrap">
								Berita Acara
							</h2>
							<h5 class="text-h5 text-no-wrap mb-3">
								{{ statsBerita }}
							</h5>
						</VCol>

						<VCol cols="12" sm="6" lg="3">
							<h1 class="text-primary">
								<VIcon>bx-book</VIcon>
							</h1>
							<h2 class="mb-1 text-h5 text-no-wrap">
								Edukasi
							</h2>
							<h5 class="text-h5 text-no-wrap mb-3">
								{{ statsEdukasi }}
							</h5>
						</VCol>
						<VCol cols="12" sm="6" lg="3">
							<h1 class="text-primary">
								<VIcon>bx-image</VIcon>
							</h1>
							<h2 class="mb-1 text-h5 text-no-wrap">
								Galeri
							</h2>
							<h5 class="text-h5 text-no-wrap mb-3">
								{{ statsGambar }}
							</h5>
						</VCol>
						<VCol cols="12" sm="6" lg="3">
							<h1 class="text-primary">
								<VIcon>bx-face</VIcon>
							</h1>
							<h2 class="mb-1 text-h5 text-no-wrap">
								Bayi Terdata
							</h2>
							<h5 class="text-h5 text-no-wrap mb-3">
								{{ statsBayi }}
							</h5>
						</VCol>
					</VRow>
				</VCardItem>
			</VCard>
		</VCol>
	</VRow>
</template>