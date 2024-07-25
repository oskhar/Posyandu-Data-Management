<script setup>
import { ref, reactive, onMounted, computed } from 'vue';
import { useRoute } from 'vue-router';
import Swal from 'sweetalert2';
import { getErrorMessage } from '@/utils/get-error-message';
import { getWhatsappLink } from '@/utils/send-whatsapp';
import { rupiahFormatter } from '@/@core/utils/formatters';
import { fetchDetailProduk } from './api/si-binggo-pages-api';

const route = useRoute();
const isLoading = ref(true);

const dataProduk = reactive({});
const currentPrice = ref(0);
const amount = ref(1);

async function fetchData() {
	try {
		isLoading.value = true;

		const idProduk = route.params.id;

		Object.assign(dataProduk, await fetchDetailProduk(idProduk));
		currentPrice.value = dataProduk.harga;
	} catch (error) {
		await Swal.fire({
			icon: "error",
			text: getErrorMessage(error, "Terjadi kesalahan saat loading data produk!"),
			showCloseButton: true,
		});
	} finally {
		isLoading.value = false;
	}
}

function increaseAmount() {
	amount.value++;
	currentPrice.value = dataProduk.harga * amount.value;
}

function decreaseAmount() {
	if (amount.value <= 1) {
		return;
	}

	amount.value--;
	currentPrice.value = dataProduk.harga * amount.value;
}


const whatsappLink = computed(() => {
	if (!dataProduk.nomor_telepon || !dataProduk.deskripsi) {
		return '#';
	}

	return getWhatsappLink(
		dataProduk.nomor_telepon,
		`Halo admin, saya ingin membeli produk "${dataProduk.nama}"" dengan kuantitas ${amount.value} yang ada di website SiBinggo.`,
	);
})

onMounted(fetchData);
</script>


<template>
	<VRow tag="section" class="px-5 mb-4">
		<VCol cols="12" md="9" class="mx-auto">
			<VCard>
				<VCardItem>
					<VBtn prepend-icon="bx-left-arrow-alt" variant="text" to="/layanan/si-binggo/produk/cari" class="mb-4">
						Kembali
					</VBtn>

					<VRow class="flex-column flex-md-row">
						<VCol cols="12" md="7">
							<VSkeletonLoader v-if="isLoading" type="image" />
							<VImg v-else :src="dataProduk.gambar" class="rounded-lg position-sticky" style="top: 110px;" />
						</VCol>


						<VCol cols="12" md="5">
							<VSkeletonLoader v-if="isLoading" type="heading" />
							<h1 v-else class="text-h5 text-sm-h4 text-primary font-weight-bold">
								{{ dataProduk.nama }}
							</h1>

							<VSkeletonLoader v-if="isLoading" type="subtitle" />
							<span v-else class="mb-2 d-flex gap-10 align-center font-weight-bold text-h6">
								{{ rupiahFormatter(currentPrice) }}
							</span>

							<VSkeletonLoader v-if="isLoading" type="subtitle" />
							<div v-else-if="!isLoading && dataProduk.sedang_dijual" class="d-flex gap-3 align-center">
								<VBtn icon="bx-minus" size="28" variant="tonal" @click="decreaseAmount" />
								<span class="font-weight-bold text-subtitle-1">{{ amount }}</span>
								<VBtn icon="bx-plus" size="28" variant="tonal" @click="increaseAmount" />
							</div>

							<VSkeletonLoader v-if="isLoading" type="paragraph" />
							<div v-else class="mt-6 tantangan-description text-justify w-100" v-html="dataProduk.deskripsi" />

							<VSkeletonLoader v-if="isLoading" type="button" />
							<a v-else :disabled="!dataProduk.sedang_dijual" target="_blank" rel="noopener noreferrer"
								:href="dataProduk.sedang_dijual ? whatsappLink : '#'">
								<VBtn :disabled="!dataProduk.sedang_dijual" class="w-100 mt-4">
									{{ dataProduk.sedang_dijual ? 'Beli Sekarang' : 'Tidak Dijual' }}
								</VBtn>
							</a>
						</VCol>
					</VRow>
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