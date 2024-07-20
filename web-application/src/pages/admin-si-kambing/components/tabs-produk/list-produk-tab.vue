<script setup>
import { ref, watch } from "vue"
import debounce from "just-debounce";
import Swal from "sweetalert2";
import { getErrorMessage } from "@/utils/get-error-message";
import { getListProduk } from "../../api/produk-api";
import CardProduk from "@/components/cards/card-produk.vue";

const listProdukItems = ref([]);
const searchProduk = ref("");
const isSearching = ref(true);
const page = ref(1);
const banyakPage = ref([]);

const searchListProduk = async () => {
	try {
		isSearching.value = true;

		const { data, links } = await getListProduk({
			page: page.value,
			search: searchProduk.value,
		})

		listProdukItems.value = data;
		banyakPage.value = links.length - 2;
	} catch (error) {
		await Swal.fire({
			icon: 'error',
			title: 'Gagal mengambil data produk!',
			text: getErrorMessage(error, 'Gagal mengambil data produk!'),
		})
	} finally {
		isSearching.value = false;
	}
}

const debouncedSearchListProduk = debounce(searchListProduk, 350)

const changeProdukPage = newPage => {
	page.value = newPage;
	searchListProduk();
}

onMounted(searchListProduk)
watch(searchProduk, debouncedSearchListProduk)
watch(searchProduk, () => page.value = 1)
</script>

<template>
	<VRow>
		<VCol cols="12">
			<VTextField v-model="searchProduk" prepend-inner-icon="bx-search" label="Cari produk" />
		</VCol>
	</VRow>

	<VRow v-if="!isSearching">
		<VCol v-for="(produk, index) in listProdukItems" :key="index" cols="12" sm="6" md="4">
			<CardProduk :to="`/admin/layanan/si-kambing/produk/${produk.id}`" :data-produk="produk" />
		</VCol>
		<VCol v-if="listProdukItems.length === 0">
			<p class="text-center">Belum ada produk atau tidak ada hasil yang sesuai.</p>
		</VCol>
	</VRow>
	<VRow v-else>
		<VProgressCircular indeterminate color="primary" class="mt-5 mx-auto" size="50">
		</VProgressCircular>
	</VRow>


	<VRow>
		<VCol cols="12">
			<VPagination v-model="page" :total-visible="6" :disabled="isSearching" size="x-large" :length="banyakPage"
				@update:model-value="changeProdukPage" />
		</VCol>
	</VRow>
</template>