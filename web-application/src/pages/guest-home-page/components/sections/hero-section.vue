<script setup>
const { gambarGedung } = defineProps({
	gambarGedung: { type: String, required: true },
})
</script>

<template>
	<VRow tag="section" class="mt-12 position-relative">
		<VCol cols="12">
			<VCarousel hide-delimiters cycle show-arrows="hover" class="position-relative">
				<VCarouselItem src="/slideshow.jpeg" cover gradient="rgba(0, 0, 0, 0.5), rgba(0, 0, 0, 0.5)" />

				<VCarouselItem src="/slideshow.jpeg" cover gradient="rgba(0, 0, 0, 0.5), rgba(0, 0, 0, 0.5)" />

				<VCarouselItem src="/slideshow.jpeg" cover gradient="rgba(0, 0, 0, 0.5), rgba(0, 0, 0, 0.5)" />

			</VCarousel>

			<div class="position-absolute heading-text">
				<h3 class="text-white text-h5">Selamat Datang Di</h3>
				<h1 class="text-white text-h3">Sistem Informasi Posyandu RW 9</h1>
			</div>
		</VCol>
	</VRow>
</template>

<style scoped>
.heading-text {
	top: 50%;
	left: 50%;
	transform: translate(-50%, -50%);
	text-align: center;
}
</style>