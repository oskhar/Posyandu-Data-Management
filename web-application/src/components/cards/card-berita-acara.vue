<script setup>
import { getFullImagePath } from '@/utils/get-full-image-path';

const { dataBerita } = defineProps({
	dataBerita: { type: Object, required: true },
})
</script>

<template>
	<VCard :to="`/berita-acara/${dataBerita.id_berita}`">
		<VImg :src="dataBerita.gambar" cover style="height: 200px">
			<h2 v-if="dataBerita.gambar === getFullImagePath(null)" class="text-center text-secondary">
				Tidak Ada Foto
			</h2>
		</VImg>

		<VCardItem>
			<VCardTitle>{{ dataBerita.judul }}</VCardTitle>
			<sup>
				<VIcon class="text-primary">bx-calendar</VIcon> {{ dataBerita.tanggal }}
			</sup>
		</VCardItem>

		<VCardText>
			<p v-if="dataBerita.overview" class="mb-4">
				{{ dataBerita.overview }}
			</p>
			<p v-else class="text-secodary">
				..
			</p>
			<p>penulis: {{ dataBerita.nama_lengkap }}</p>
		</VCardText>
	</VCard>
</template>