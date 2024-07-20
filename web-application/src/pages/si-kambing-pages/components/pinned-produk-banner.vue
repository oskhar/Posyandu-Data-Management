<script setup lang="ts">
import { getFullImagePath } from '@/utils/get-full-image-path';
import { rupiahFormatter } from '@/utils/rupiah-formatter';
import { ref } from 'vue';

const { listDataProduk } = defineProps<any>({
	listDataProduk: { type: Array, required: true },
});


const activeWindow = ref(0);
</script>

<template>
	<VWindow v-model="activeWindow" continuous show-arrows>
		<VWindowItem v-for="dataProduk in listDataProduk" :key="dataProduk.id">
			<VCard class="d-flex justify-start align-end position-relative" height="400px"
				:to="`/layanan/si-kambing/produk/${dataProduk.id}`"
				:style="`background-image: url(${getFullImagePath(dataProduk.gambar)}); background-size: cover; background-position: center; position: relative;`">
				<div class="overlay" />

				<div class="pa-6 d-flex flex-column flex-md-row justify-space-between align-center w-100">
					<div class="position-relative" style="z-index: 10;">
						<h2 class="text-h4 text-white">{{ dataProduk.nama }}</h2>
						<p class="text-h6 text-white">{{ rupiahFormatter(dataProduk.harga) }}</p>
					</div>

					<VBtn variant="elevated" color="primary" class="w-100 w-md-auto"
						:to="`layanan/si-kambing/produk/${dataProduk.id}`" append-icon="bx-right-arrow-alt">Lihat Produk</VBtn>
				</div>
			</VCard>
		</VWindowItem>
	</VWindow>
</template>

<style scoped>
.overlay {
	position: absolute;
	top: 0;
	left: 0;
	right: 0;
	bottom: 0;
	background: linear-gradient(to bottom, rgba(0, 0, 0, 0) 0%, rgba(0, 0, 0, 0.75) 100%);
}
</style>
