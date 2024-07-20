<script setup>
import { getFullImagePath } from '@/utils/get-full-image-path';
import { rupiahFormatter } from '@/utils/rupiah-formatter';

const { dataProduk } = defineProps({
	dataProduk: { type: Object, required: true },
})
</script>

<template>
	<VCard :to="`/layanan/si-kambing/produk/${dataProduk.id}`" class="h-100">
		<VImg :src="dataProduk.gambar" cover style="height: 200px">
			<h2 v-if="dataProduk.gambar === getFullImagePath(null)" class="text-center text-secondary">
				Tidak Ada Foto
			</h2>
		</VImg>

		<VCardItem>
			<VCardTitle>{{ dataProduk.nama }}</VCardTitle>
			<VCardSubtitle class="font-weight-bold text-h6 mb-2">{{ rupiahFormatter(dataProduk.harga) }}</VCardSubtitle>
			<div class="d-flex gap-1 flex-wrap">
				<VChip v-for="(tag, i) in dataProduk.tags" :key="i">{{ tag }}</VChip>
			</div>
		</VCardItem>

		<VCardText>
			<p class="mb-4">
				{{ dataProduk.overview }}
			</p>
		</VCardText>
	</VCard>
</template>