<script setup>
import { onMounted, ref } from "vue";
import { fetchPreviewEvents } from "../../api/guest-home-page-api";
import Swal from "sweetalert2";
import { getErrorMessage } from "@/utils/get-error-message";
import CardEvent from "@/components/cards/card-event.vue";

const isLoading = ref(true);
const dataEvents = ref([]);

// Fetch preview events acara
onMounted(async () => {
	try {
		isLoading.value = true;
		dataEvents.value = await fetchPreviewEvents();
	} catch (error) {
		await Swal.fire({
			icon: "error",
			text: getErrorMessage(error, "Terjadi kesalahan saat loading data events!"),
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
			<VRow class="flex-wrap">
				<VCol cols="12" md="9">
					<h2 class="text-primary text-h5 font-weight-bold">Events</h2>
					<p class="text-secondary text-subtitle-1">
						Informasi seputar Events Posyandu Melati akan di tampilkan di
						sini
					</p>
				</VCol>
				<VCol cols="12" md="3" class="d-flex justify-end align-center">
					<VBtn variant="tonal" prepend-icon="bx-paper-plane" to="/events">
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
				<VCol v-for="(data) in dataEvents" :key="data.id_berita" cols="12" sm="6" lg="4">
					<CardEvent :data-event='data' />
				</VCol>

				<VCol v-if="dataEvents.length === 0" cols="12">
					<p class="mt-5 text-secondary text-center">Belum ada event..</p>
				</VCol>
			</VRow>
		</VCol>
	</VRow>
</template>