<script setup>
import { getFullImagePath } from '@/utils/get-full-image-path';

const { dataEdukasi } = defineProps({
	dataEdukasi: { type: Object, required: true },
})
</script>

<template>
	<VCard :to="`/edukasi/${dataEdukasi.id_edukasi}`">
		<VImg :src="dataEdukasi.gambar" cover style="height: 200px">
			<h2 v-if="dataEdukasi.gambar === getFullImagePath(null)" class="text-center text-secondary">
				Tidak Ada Foto
			</h2>
		</VImg>

		<VCardItem>
			<VCardTitle>{{ dataEdukasi.judul }}</VCardTitle>
			<sup>
				<VIcon class="text-primary">bx-calendar</VIcon> {{ dataEdukasi.tanggal }}
			</sup>
		</VCardItem>

		<VCardText>
			<p v-if="dataEdukasi.overview" class="mb-4">
				{{ dataEdukasi.overview }}
			</p>
			<p v-else class="text-secodary">
				..
			</p>
			<p>penulis: {{ dataEdukasi.nama_lengkap }}</p>
		</VCardText>
	</VCard>
</template>