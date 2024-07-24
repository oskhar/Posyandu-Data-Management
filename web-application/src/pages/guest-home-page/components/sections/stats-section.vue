<script setup>
const { statsEvents, statsEdukasi, statsBayi, statsGambar } = defineProps({
	statsEvents: { type: Number, required: true },
	statsEdukasi: { type: Number, required: true },
	statsGambar: { type: Number, required: true },
	statsBayi: { type: Number, required: true },
})
</script>

<template>
	<VRow tag="section" class="px-5">
		<VCol cols="12" md="9" class="mx-auto">
			<VCard>
				<VCardItem class="pa-0">
					<VRow class="text-center">
						<VCol v-ripple cols="12" sm="6" lg="3">
							<RouterLink class="d-block pa-8" to="/events">
								<VIcon class="text-primary text-h4">bx-news</VIcon>
								<h2 class="mb-1 text-h6 text-no-wrap">
									Events
								</h2>
								<h5 class="text-h5 mb-3">
									{{ statsEvents }}
								</h5>
							</RouterLink>
						</VCol>

						<VCol v-ripple cols="12" sm="6" lg="3">
							<RouterLink class="d-block pa-8" to="/edukasi">
								<VIcon class="text-primary text-h4">bx-book</VIcon>
								<h2 class="mb-1 text-h6 text-no-wrap">
									Edukasi
								</h2>
								<h5 class="text-h5 mb-3">
									{{ statsEdukasi }}
								</h5>
							</RouterLink>
						</VCol>
						<VCol v-ripple cols="12" sm="6" lg="3">
							<a href="#galeri" class="d-block pa-8">
								<VIcon class="text-primary text-h4">bx-image</VIcon>
								<h2 class="mb-1 text-h6 text-no-wrap">
									Galeri
								</h2>
								<h5 class="text-h5 mb-3">
									{{ statsGambar }}
								</h5>
							</a>
						</VCol>
						<VCol v-ripple cols="12" sm="6" lg="3">
							<RouterLink class="d-block pa-8" to="/layanan/screening-balita">
								<VIcon class="text-primary text-h4">bx-face</VIcon>
								<h2 class="mb-1 text-h6 text-no-wrap">
									Bayi Terdata
								</h2>
								<h5 class="text-h5 mb-3">
									{{ statsBayi }}
								</h5>
							</RouterLink>
						</VCol>
					</VRow>
				</VCardItem>
			</VCard>
		</VCol>
	</VRow>
</template>