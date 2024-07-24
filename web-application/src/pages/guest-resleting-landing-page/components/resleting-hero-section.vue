<template>
	<VRow id="resleting-hero-section" style="scroll-margin-top: 60px;" tag="section"
		class="mt-12 pt-16 pb-8 position-relative px-5">
		<VCol cols="12" md="9" class="mx-auto">
			<VRow align="center" justify="space-between" class="gap-6">
				<VCol cols="12" md="6">
					<div class="d-flex gap-4 mb-4 align-center">
						<img style="width: 50px;" src="/resleting-logo.webp" alt="Gambar hero produk" />
						<p class="ma-0 text-h4 text-md-h3 font-weight-bold text-grey-900">
							Resleting
						</p>
					</div>

					<h1 class="text-h4 text-lg-h3 font-weight-bold">
						Sebarkan
						<span class="text-primary">
							Awareness
						</span>
						Tentang
						<span class="text-primary">
							Stunting
						</span>
						Bersama
						<span class="text-primary">
							Resleting.
						</span>
					</h1>
					<p class="text-subtitle-1 text-md-h6 mt-4">
						Meningkatkan kesadaran tentang stunting dan memberdayakan remaja dalam mengatasi masalah ini.
					</p>

					<VBtn variant="elevated" color="primary" class="w-100 w-sm-auto" height="52"
						to="/layanan/remaja-peduli-stunting/tantangan" append-icon="bx-right-arrow-alt">Lihat Tantangan</VBtn>
				</VCol>

				<VCol cols="12" sm="6" md="5" class="mx-auto">
					<img class="w-100" src="/people-resleting.svg" alt="Gambar hero resleting" />
				</VCol>
			</VRow>
		</VCol>
	</VRow>
</template>
