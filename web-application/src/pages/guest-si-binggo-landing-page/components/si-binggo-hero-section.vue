<template>
	<VRow id="hero-section" tag="section" class="py-8 position-relative px-5">
		<VCol cols="12" md="9" class="mx-auto">
			<VRow align="center" justify="space-between" class="gap-6">
				<VCol cols="12" md="6">
					<div class="d-flex gap-4 mb-4 align-center">
						<img style="width: 70px;" src="/sibingo.webp" alt="Gambar hero produk" />
						<p class="text-h4 text-si-binggo text-md-h3 font-weight-bold ma-0">
							SiBinggo
						</p>
					</div>

					<h1 class="text-h4 text-lg-h3 font-weight-bold">
						Dapatkan Produk Bernutrisi Hewani Terbaik Untuk Keluarga Anda
					</h1>
					<p class="text-subtitle-1 text-md-h6 mt-4">
						Jelajahi produk kami, temukan barang yang Anda inginkan, dan hubungi penjual langsung untuk
						transaksi mudah.
					</p>

					<VBtn variant="elevated" color="primary" class="w-100 w-sm-auto" height="52"
						to="/layanan/si-binggo/produk/cari" append-icon="bx-right-arrow-alt">Lihat Produk</VBtn>
				</VCol>

				<VCol cols="12" sm="6" md="5" class="mx-auto">
					<img class="w-100 rounded-lg elevation-10" src="/keluarga-belanja.svg" alt="Gambar hero produk" />
				</VCol>
			</VRow>
		</VCol>
	</VRow>
</template>
