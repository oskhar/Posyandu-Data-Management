<script setup>
import { onMounted, ref } from "vue";
import { fetchGallery } from "../../api/guest-home-page-api";
import Swal from "sweetalert2";
import { getErrorMessage } from "@/utils/get-error-message";
import CardGallery from "@/components/cards/card-gallery.vue";

const isLoading = ref(true);
const dataGambar = ref([]);
const page = ref(1);
const banyakPage = ref(0);


const fetchPictures = async () => {
	try {
		isLoading.value = true;

		const { pictures, pages } = await fetchGallery();

		dataGambar.value = pictures;
		banyakPage.value = pages;

	} catch (error) {
		await Swal.fire({
			icon: "error",
			text: getErrorMessage(error, "Terjadi kesalahan saat loading data gallery!"),
			showCloseButton: true,
		});
	} finally {
		isLoading.value = false;
	}
}

// Fetch preview gallery
onMounted(fetchPictures)
</script>

<template>
	<VRow tag="section" class="px-5">
		<VCol cols="12" md="9" class="mx-auto text-center">
			<h2 class="mt-5 text-h5 font-weight-bold text-primary">Galeri Kami</h2>
			<p class="text-secondary text-subtitle-1">
				Kisah yang diabadikan dalam bentuk Foro akan di tampilkan di
				sini
			</p>

			<VRow v-if="isLoading">
				<VCol v-for="n in 8" :key="n" cols="12" sm="6" lg="3">
					<VSkeletonLoader class="mx-auto border" type="image" />
				</VCol>
			</VRow>
			<VRow v-else>
				<VCol v-for="data in dataGambar" :key="data.gambar" cols="12" sm="6" md="3">
					<CardGallery :data-gambar="data" />
				</VCol>
			</VRow>

			<VRow>
				<VCol cols="12">
					<div class="my-3">
						<VPagination v-model="page" size="x-large" :length="banyakPage" :total-visible="6" @click="fetchPictures">
						</VPagination>
					</div>
				</VCol>
			</VRow>
		</VCol>
	</VRow>
</template>