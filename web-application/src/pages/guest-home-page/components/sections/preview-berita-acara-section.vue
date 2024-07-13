<script setup>
import { onMounted, ref } from "vue";
import { fetchPreviewBeritaAcara } from "../../api/guest-home-page-api";
import Swal from "sweetalert2";
import { getErrorMessage } from "@/utils/get-error-message";
import CardBeritaAcara from "@/components/cards/card-berita-acara.vue";

const isLoading = ref(true);
const dataBeritaAcara = ref([]);

// Fetch preview berita acara
onMounted(async () => {
	try {
		isLoading.value = true;
		dataBeritaAcara.value = await fetchPreviewBeritaAcara();
	} catch (error) {
		await Swal.fire({
			icon: "error",
			text: getErrorMessage(error, "Terjadi kesalahan saat loading data berita & acara!"),
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
			<h2 class="text-primary text-h5 font-weight-bold">Berita & Acara</h2>
			<p class="text-secondary text-subtitle-1">
				Informasi seputar Berita & Acara Posyandu Melati akan di tampilkan di
				sini
			</p>

			<VRow v-if="isLoading">
				<VCol cols="12" sm="6" lg="4">
					<VSkeletonLoader class="mx-auto border" type="image, article" />
				</VCol>
				<VCol cols="12" sm="6" lg="4">
					<VSkeletonLoader class="mx-auto border" type="image, article" />
				</VCol>
				<VCol cols="12" sm="6" lg="4">
					<VSkeletonLoader class="mx-auto border" type="image, article" />
				</VCol>
			</VRow>

			<VRow v-else class="mt-5">
				<VCol v-for="(data) in dataBeritaAcara" :key="data.id_berita" cols="12" sm="6" lg="4">
					<RouterLink :to="`./edukasi-guest?id_berita=${data.id_berita}`">
						<CardBeritaAcara :data-berita='data' />
					</RouterLink>
				</VCol>

				<VCol v-if="dataBeritaAcara.length === 0" cols="12">
					<p class="mt-5 text-secondary text-center">Belum ada berita & acara..</p>
				</VCol>
			</VRow>
		</VCol>
	</VRow>
</template>