<script setup>
import { onMounted, ref, watch } from "vue";
import { fetchListProduk } from "./api/si-kambing-pages-api";
import { getErrorMessage } from "@/utils/get-error-message";
import Swal from "sweetalert2";
import CardProduk from "@/components/cards/card-produk.vue";
import debounce from "just-debounce";
import TagCombobox from "./components/tag-combobox.vue";

const isSearching = ref(true);
const isInitialLoading = ref(true);
const dataProduk = ref([]);
const chosenTags = ref([]);
const page = ref(1);
const banyakPage = ref(0);
const searchQuery = ref("");

const searchProduk = async () => {
	try {
		isSearching.value = true;

		const { listProduk, pages } = await fetchListProduk({
			length: 6,
			page: page.value,
			search: searchQuery.value,
			tags: chosenTags.value,
		});

		dataProduk.value = listProduk;
		banyakPage.value = pages;

	} catch (error) {
		await Swal.fire({
			icon: "error",
			text: getErrorMessage(error, "Terjadi kesalahan saat loading data produk!"),
			showCloseButton: true,
		});
	} finally {
		isSearching.value = false;
	}
}

const debouncedSearchProduk = debounce(searchProduk, 350)

const changeSearchPage = newPage => {
	page.value = newPage;
	searchProduk();
}

const changeChosenTags = tags => {
	chosenTags.value = tags;
	debouncedSearchProduk();
}

onMounted(async () => {
	await searchProduk()
	isInitialLoading.value = false
});

watch(searchQuery, debouncedSearchProduk)
watch(searchQuery, () => page.value = 1)
</script>

<template>
	<VRow tag="section" class="px-5 mb-4" style="margin-top: 90px;">
		<VCol cols="12" md="9" class="mx-auto">
			<h1 class="text-primary text-h5 font-weight-bold">Cari Produk</h1>
			<p class="text-secondary text-subtitle-1">
				Informasi seputar Produk dari SiKambing
			</p>


			<div class="d-flex gap-4 align-center">
				<VTextField v-model="searchQuery" prepend-inner-icon="bx-search" label="Cari Postingan Produk" />
				<TagCombobox @change="changeChosenTags" />
			</div>

			<VRow v-if="isSearching && isInitialLoading" class="mt-5">
				<VCol v-for="i in 6" :key="i" cols="12" sm="6" lg="4">
					<VSkeletonLoader class="mx-auto border" type="image, article" />
				</VCol>
			</VRow>
			<VRow v-else-if="isSearching && !isInitialLoading" class="mt-5">
				<VCol cols="12" class="d-flex justify-center">
					<VProgressCircular indeterminate color="primary" size="50">
					</VProgressCircular>
				</VCol>
			</VRow>
			<VRow v-else class="mt-5">
				<VCol v-for="(data) in dataProduk" :key="data.id" cols="12" sm="6" md="4">
					<CardProduk :data-produk="data" />
				</VCol>
				<VCol v-if="dataProduk.length === 0" cols="12">
					<p class="mt-5 text-secondary text-center">Belum ada produk dari SiKambing...</p>
				</VCol>
			</VRow>

			<VRow>
				<VCol cols="12">
					<VPagination v-model="page" :disabled="isSearching" size="x-large" :total-visible="5"
						:length="banyakPage || 1" @update:model-value="changeSearchPage" />
				</VCol>
			</VRow>
		</VCol>
	</VRow>
</template>
