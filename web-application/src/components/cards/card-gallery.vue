<script setup>
import Swal from "sweetalert2";

const { dataGambar } = defineProps({
	dataGambar: { type: Object, required: true },
})

const lihatGambar = (gambar, judul) => {
	Swal.fire({
		imageUrl: gambar,
		html: judul,
		imageAlt: judul,
	});
}
</script>

<template>
	<VImg aspect-ratio="1" width="100%" cover :src="dataGambar.gambar" alt="image" class="rounded cursor-pointer"
		@click="lihatGambar(dataGambar.gambar, dataGambar.nama_lengkap)" />
</template>