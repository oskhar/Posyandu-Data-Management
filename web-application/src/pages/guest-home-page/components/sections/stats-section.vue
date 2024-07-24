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
		<VCol cols=" 12" md="9" class="mx-auto text-center">
			<h2 class="text-h5 font-weight-bold text-primary">Layanan Kami</h2>
			<p class="text-secondary text-subtitle-1">
				Layanan dari SiDilan yang kami sediakan untuk anda
			</p>
		</VCol>
		<VCol cols="12" md="9" class="mx-auto">
			<VCard>
				<VCardItem class="pa-0">
					<VRow class="text-center">
						<VCol v-ripple cols="12" sm="6">
							<RouterLink class="d-block pa-4 d-flex align-center flex-column" to="/layanan/resleting">
								<VImg src="/resleting-logo.webp" height="65" width="auto" />
								<h2 class="mb-0 mt-2 text-h5 text-grey-900 text-no-wrap font-weight-bold">
									Resleting
								</h2>
								<p class="text-subtitle-1 text-grey-900 ma-0">
									Remaja Sigap Dan Peduli Stunting
								</p>
							</RouterLink>
						</VCol>

						<VCol v-ripple cols="12" sm="6">
							<RouterLink class="d-block pa-4 d-flex align-center flex-column" to="/layanan/si-binggo">
								<VImg src="/sibingo.webp" height="65" width="auto" />
								<h2 class="mb-0 mt-2 text-h5 text-no-wrap font-weight-bold text-si-binggo">
									SiBinggo
								</h2>
								<p class="text-subtitle-1 text-si-binggo ma-0">
									Sistem Kambing Dan Go
								</p>
							</RouterLink>
						</VCol>
					</VRow>

					<VRow class="text-center">
						<VCol v-ripple cols="12" sm="6" lg="3">
							<RouterLink class="d-block pa-4" to="/events">
								<VIcon class="text-primary text-h4">bx-news</VIcon>
								<h2 class="font-weight-bold mt-1 text-h6 text-primary">
									Events
								</h2>
								<p class="text-h6 text-primary ma-0">
									{{ statsEvents }}
								</p>
							</RouterLink>
						</VCol>

						<VCol v-ripple cols="12" sm="6" lg="3">
							<RouterLink class="d-block pa-4" to="/edukasi">
								<VIcon class="text-primary text-h4">bx-book</VIcon>
								<h2 class="font-weight-bold mt-1 text-h6 text-primary">
									Edukasi
								</h2>
								<p class="text-h6 text-primary ma-0">
									{{ statsEdukasi }}
								</p>
							</RouterLink>
						</VCol>
						<VCol v-ripple cols="12" sm="6" lg="3">
							<a href="#galeri" class="d-block pa-4">
								<VIcon class="text-primary text-h4">bx-image</VIcon>
								<h2 class="font-weight-bold mt-1 text-h6 text-primary">
									Galeri
								</h2>
								<p class="text-h6 text-primary ma-0">
									{{ statsGambar }}
								</p>
							</a>
						</VCol>
						<VCol v-ripple cols="12" sm="6" lg="3">
							<RouterLink class="d-block pa-4" to="/layanan/screening-balita">
								<VIcon class="text-primary text-h4">bx-face</VIcon>
								<h2 class="font-weight-bold mt-1 text-h6 text-primary">
									Screening Balita
								</h2>
								<p class="text-h6 text-primary ma-0">
									{{ statsBayi }}
								</p>
							</RouterLink>
						</VCol>
					</VRow>
				</VCardItem>
			</VCard>
		</VCol>
	</VRow>
</template>