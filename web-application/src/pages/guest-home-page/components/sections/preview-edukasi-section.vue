<script setup>
import { onMounted, ref } from "vue";
import { fetchPreviewEdukasi } from "../../api/guest-home-page-api";
import Swal from "sweetalert2";
import CardEdukasi from "@/components/cards/card-edukasi.vue";

const isLoading = ref(true);
const dataEdukasi = ref([]);

// Fetch preview edukasi
onMounted(async () => {
	try {
		isLoading.value = true;
		dataEdukasi.value = await fetchPreviewEdukasi();
	} catch (error) {
		await Swal.fire({
			icon: "error",
			text: getErrorMessage(error, "Terjadi kesalahan saat loading data edukasi!"),
			showCloseButton: true,
		});
	} finally {
		isLoading.value = false;
	}
})
</script>


<template>
	<VRow tag="section" class="px-5">
		<VCol cols="12" md="9" class="mx-auto">
			<h2 class="text-primary text-h5 font-weight-bold">Penyuluhan Edukasi</h2>
			<p class="text-secondary text-subtitle-1">
				Informasi seputar Edukasi Posyandu Melati akan di tampilkan di
				sini
			</p>

			<VRow v-if="isLoading">
				<VCol v-for="i in 3" :key="i" cols="12" sm="6" lg="4">
					<VSkeletonLoader class="mx-auto border" type="image, article" />
				</VCol>
			</VRow>

			<VRow v-else class="mt-5">
				<VCol v-for="(data) in dataEdukasi" :key="data.id_edukasi" cols="12" sm="6" lg="4">
					<CardEdukasi :data-edukasi="data" />
				</VCol>

				<VCol v-if="dataEdukasi.length === 0" cols="12">
					<p class="mt-5 text-secondary text-center">Belum ada edukasi..</p>
				</VCol>
			</VRow>
		</VCol>
	</VRow>
</template>