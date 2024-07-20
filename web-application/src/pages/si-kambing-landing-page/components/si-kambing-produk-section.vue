<script setup>
import { onMounted, ref } from "vue";
import Swal from "sweetalert2";
import { getErrorMessage } from "@/utils/get-error-message";
import { fetchProdukPreviews } from "../api/si-kambing-landing-page-api";
import CardProduk from "@/components/cards/card-produk.vue";

const isLoading = ref(true);
const dataProduk = ref([]);

onMounted(async () => {
	try {
		isLoading.value = true;

		dataProduk.value = await fetchProdukPreviews();
	} catch (error) {
		await Swal.fire({
			icon: "error",
			text: getErrorMessage(error, "Terjadi kesalahan saat loading produk!"),
			showCloseButton: true,
		});
	} finally {
		isLoading.value = false;
	}
})
</script>


<template>
	<VRow tag="section" class="px-5 py-6">
		<VCol cols="12" md="9" class="mx-auto">
			<VRow>
				<VCol cols="12" md="9">
					<h2 class="text-primary text-h5 text-lg-h4 font-weight-bold">Produk Yang Dijual</h2>
					<p class="text-secondary text-subtitle-1">
						Tantangan yang anda dapat ikuti, menangkan dan dapatkan hadiahnya!
					</p>
				</VCol>
				<VCol cols="12" md="3" class="d-flex justify-end align-center">
					<VBtn variant="tonal" prepend-icon="bx-paper-plane" to="/layanan/si-kambing/produk/cari">
						Lihat Semua
					</VBtn>
				</VCol>
			</VRow>

			<VRow v-if="isLoading">
				<VCol v-for="i in 3" :key="i" cols="12" sm="6" lg="4">
					<VSkeletonLoader class="mx-auto border" type="image, article" />
				</VCol>
			</VRow>

			<VRow v-else class="mt-5">
				<VCol v-for="(data) in dataProduk" :key="data.id" cols="12" sm="6" lg="4">
					<CardProduk :data-produk="data" />
				</VCol>

				<VCol v-if="dataProduk.length === 0" cols="12">
					<p class="mt-5 text-secondary text-center">Belum ada Tantangan..</p>
				</VCol>
			</VRow>
		</VCol>
	</VRow>
</template>