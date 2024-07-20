<script setup>
import { onMounted, ref, watch } from "vue";
import { getErrorMessage } from "@/utils/get-error-message";
import Swal from "sweetalert2";
import debounce from "just-debounce";
import CardTantangan from "@/components/cards/card-tantangan.vue";
import { fetchDataTantangan } from "../../api/resliting-tantangan-page-api";

const isSearching = ref(true);
const isInitialLoading = ref(true);
const dataTantangan = ref([]);
const page = ref(1);
const banyakPage = ref(0);
const searchQuery = ref("");

const searchTantangan = async () => {
	try {
		isSearching.value = true;

		const { data, current_page, links } = await fetchDataTantangan({
			page: page.value,
			search: searchQuery.value,
		});

		dataTantangan.value = data;
		banyakPage.value = links.length;
		page.value = current_page;

	} catch (error) {
		await Swal.fire({
			icon: "error",
			text: getErrorMessage(error, "Terjadi kesalahan saat loading data tantangan!"),
			showCloseButton: true,
		});
	} finally {
		isSearching.value = false;
	}
}

const debouncedSearchTantangan = debounce(searchTantangan, 350)

const changeSearchPage = newPage => {
	page.value = newPage;
	searchTantangan();
}

onMounted(async () => {
	await searchTantangan()
	isInitialLoading.value = false
});

watch(searchQuery, debouncedSearchTantangan)
watch(searchQuery, () => page.value = 1)
</script>

<template>
	<VTextField v-model="searchQuery" prepend-inner-icon="bx-search" label="Cari Semua Tantangan" />

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
		<VCol v-for="(data) in dataTantangan" :key="data.id" cols="12" sm="6" md="4">
			<CardTantangan :data-tantangan="data" />
		</VCol>
		<VCol v-if="dataTantangan.length === 0" cols="12">
			<p class="mt-5 text-secondary text-center">Belum ada tantangan...</p>
		</VCol>
	</VRow>

	<VRow>
		<VCol cols="12">
			<VPagination v-model="page" :disabled="isSearching" size="x-large" :total-visible="6" :length="banyakPage || 1"
				@update:model-value="changeSearchPage" />
		</VCol>
	</VRow>
</template>