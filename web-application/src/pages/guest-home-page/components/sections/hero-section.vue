<script setup>
const { gambarGedung } = defineProps({
	gambarGedung: { type: String, required: true },
})
</script>

<template>
	<VRow tag="section" class="mt-12 position-relative">
		<VCol cols="12">
			<VCarousel hide-delimiters cycle show-arrows="hover" class="position-relative">
				<VCarouselItem src="https://cdn.vuetifyjs.com/images/cards/docks.jpg" cover
					gradient="rgba(0, 0, 0, 0.5), rgba(0, 0, 0, 0.5)" />

				<VCarouselItem src="https://cdn.vuetifyjs.com/images/cards/hotel.jpg" cover
					gradient="rgba(0, 0, 0, 0.5), rgba(0, 0, 0, 0.5)" />

				<VCarouselItem src="https://cdn.vuetifyjs.com/images/cards/sunshine.jpg" cover
					gradient="rgba(0, 0, 0, 0.5), rgba(0, 0, 0, 0.5)" />

			</VCarousel>

			<div class="position-absolute heading-text">
				<h3 class="text-white text-h5">SELAMAT DATANG DI</h3>
				<h1 class="text-white text-h3">POSYANDU MELATI</h1>
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