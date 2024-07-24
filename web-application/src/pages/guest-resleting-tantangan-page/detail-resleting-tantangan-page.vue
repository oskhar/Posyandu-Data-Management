<script setup>
import { ref, reactive, onMounted } from 'vue';
import { useRoute } from 'vue-router';
import { fetchDataDetailTantangan } from './api/resleting-tantangan-page-api';
import Swal from 'sweetalert2';
import { getErrorMessage } from '@/utils/get-error-message';
import DetailTantanganFormDialog from './components/detail-tantangan-form-dialog.vue';

const route = useRoute();
const isLoading = ref(true);

const dataTantangan = reactive({});

async function fetchData() {
	try {
		isLoading.value = true;

		const idTantangan = route.params.id;

		Object.assign(dataTantangan, await fetchDataDetailTantangan(idTantangan));
	} catch (error) {
		await Swal.fire({
			icon: "error",
			text: getErrorMessage(error, "Terjadi kesalahan saat loading data tantangan!"),
			showCloseButton: true,
		});
	} finally {
		isLoading.value = false;
	}
}

onMounted(fetchData);
</script>


<template>
	<VRow tag="section" class="px-5 mb-4" style="margin-top: 90px;">

		<VCol cols="12" md="9" class="mx-auto">
			<VBtn prepend-icon="bx-left-arrow-alt" variant="text" to="/layanan/remaja-peduli-stunting/tantangan" class="mb-4">
				Kembali
			</VBtn>

			<VRow class="mb-2" align="center">
				<VCol cols="12" md="9" lg="10">
					<VSkeletonLoader v-if="isLoading" type="heading" />
					<h1 v-else class="text-h5 text-sm-h4 text-primary font-weight-bold">
						{{ dataTantangan.judul }}
					</h1>

					<VSkeletonLoader v-if="isLoading" type="subtitle" />
					<div v-else class="d-flex align-center gap-2 mt-2 mb-4">
						<VIcon icon="mdi-calendar" size="18" />
						<span>
							Mulai: {{ dataTantangan.tanggal_mulai }}
						</span>
						/
						<span>
							Akhir: {{ dataTantangan.tanggal_selesai }}
						</span>
					</div>
				</VCol>
				<VCol cols="12" md="3" lg="2">
					<VSkeletonLoader v-if="isLoading" type="button" />
					<div v-else>
						<VBtn v-if="!dataTantangan.user_submitted" id="ikuti-tantangan" class="w-100">
							Ikuti Tantangan
						</VBtn>
						<VBtn v-else disabled class="w-100">
							Telah Diikuti
						</VBtn>

						<DetailTantanganFormDialog :tantangan-id="route.params.id" activator="#ikuti-tantangan"
							@finish-submit="fetchData" />
					</div>
				</VCol>
			</VRow>

			<VSkeletonLoader v-if="isLoading" type="image, paragraph" />

			<div>
				<div class="rounded-lg overflow-hidden">
					<VImg :src="dataTantangan.gambar" class="h-full" />
				</div>

				<div class="mt-6 tantangan-description" v-html="dataTantangan.deskripsi">
				</div>
			</div>
		</VCol>
	</VRow>
</template>

<style scoped>
.tantangan-description>* {
	margin-bottom: 20px;
}

.v-skeleton-loader {
	background-color: transparent;
}
</style>