<script setup>
import { getFullImagePath } from '@/utils/get-full-image-path';

const { dataTantangan, to } = defineProps({
	dataTantangan: { type: Object, required: true },
	to: { type: String },
})
</script>

<template>
	<VCard :to="to || `/layanan/resleting/tantangan/${dataTantangan.id}`">
		<VImg :src="dataTantangan.gambar" cover style="height: 200px">
			<h2 v-if="dataTantangan.gambar === getFullImagePath(null)" class="text-center text-secondary">
				Tidak Ada Foto
			</h2>
		</VImg>

		<VCardItem>
			<VCardTitle>{{ dataTantangan.judul }}</VCardTitle>
			<div class="text-caption d-flex gap-1 align-center">
				<VIcon class="text-primary">bx-calendar</VIcon>
				<div class="d-flex gap-1">
					<span>Mulai: {{ dataTantangan.tanggal_mulai }}</span>
					/
					<span>Akhir: {{ dataTantangan.tanggal_selesai }}</span>
				</div>
			</div>
		</VCardItem>

		<VCardText>
			<div class="mb-4 position-relative text-secodary">
				<p v-if="dataTantangan.overview" style="height: 80px;">
					{{ dataTantangan.overview.split(0, 40).join(" ") }}...
				</p>
				<p v-else>
					...
				</p>
			</div>
		</VCardText>
	</VCard>
</template>