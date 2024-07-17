<script setup>
import { getFullImagePath } from '@/utils/get-full-image-path';

const { dataTantangan } = defineProps({
	dataTantangan: { type: Object, required: true },
})
</script>

<template>
	<VCard :to="`/layanan/remaja-peduli-stunting/tantangan/${dataTantangan.id_edukasi}`">
		<VImg :src="dataTantangan.gambar" cover style="height: 200px">
			<h2 v-if="dataTantangan.gambar === getFullImagePath(null)" class="text-center text-secondary">
				Tidak Ada Foto
			</h2>
		</VImg>

		<VCardItem>
			<VCardTitle>{{ dataTantangan.judul }}</VCardTitle>
			<sup>
				<VIcon class="text-primary">bx-calendar</VIcon> {{ dataTantangan.tanggal_mulai }} - {{
					dataTantangan.tanggal_selesai }}
			</sup>
		</VCardItem>

		<VCardText>
			<div class="mb-4 position-relative text-secodary">
				<p v-if="dataTantangan.deskripsi" style="height: 80px;">
					{{ dataTantangan.deskripsi.split(0, 40).join(" ") }}...
				</p>
				<p v-else>
					...
				</p>
			</div>
		</VCardText>
	</VCard>
</template>