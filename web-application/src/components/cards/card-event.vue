<script setup>
import { getFullImagePath } from '@/utils/get-full-image-path';

const { dataEvent } = defineProps({
	dataEvent: { type: Object, required: true },
})
</script>

<template>
	<VCard :to="`/events/${dataEvent.id_berita}`">
		<VImg :src="dataEvent.gambar" cover style="height: 200px">
			<h2 v-if="dataEvent.gambar === getFullImagePath(null)" class="text-center text-secondary">
				Tidak Ada Foto
			</h2>
		</VImg>

		<VCardItem>
			<VCardTitle>{{ dataEvent.judul }}</VCardTitle>
			<sup>
				<VIcon class="text-primary">bx-calendar</VIcon> {{ dataEvent.tanggal }}
			</sup>
		</VCardItem>

		<VCardText>
			<p v-if="dataEvent.overview" class="mb-4">
				{{ dataEvent.overview }}
			</p>
			<p v-else class="text-secodary">
				..
			</p>
			<p>penulis: {{ dataEvent.nama_lengkap }}</p>
		</VCardText>
	</VCard>
</template>