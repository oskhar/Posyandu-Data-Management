<script setup>
import { ref, onMounted } from 'vue';
import { useRoute, useRouter } from 'vue-router';
import { fetchDataDetailTantangan } from './api/resleting-tantangan-page-api';
import { getErrorMessage } from '@/utils/get-error-message';
import DetailTantanganFormDialog from './components/detail-tantangan-form-dialog.vue';
import { errorToast } from '@/utils/toast';

const route = useRoute();
const router = useRouter();
const isLoading = ref(true);

const dataTantangan = ref({});

async function fetchData() {
	try {
		const idTantangan = route.params.id;

		dataTantangan.value = await fetchDataDetailTantangan(idTantangan);
	} catch (error) {
		errorToast({ text: getErrorMessage(error) })
		router.push('/layanan/resleting/tantangan')
	} finally {
		isLoading.value = false;
		if (dataTantangan.value.judul === undefined) {
			errorToast({ text: "Postingan tantangan gagal diambil!" })
			router.push('/layanan/resleting/tantangan')
		}

	}
}

onMounted(fetchData);
</script>


<template>
	<VRow tag="section" class="px-5 mb-4">

		<VCol cols="12" md="9" class="mx-auto">
			<VCard>
				<VCardItem>
					<VBtn prepend-icon="bx-left-arrow-alt" variant="text" to="/layanan/resleting/tantangan" class="mb-4">
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
				</VCardItem>

			</VCard>

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