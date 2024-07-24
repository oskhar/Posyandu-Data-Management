<script setup>
import { ref, watch } from "vue"
import debounce from "just-debounce";
import Swal from "sweetalert2";
import { getErrorMessage } from "@/utils/get-error-message";
import { getListTantangan } from "../../api/tantangan-api";
import CardTantangan from "@/components/cards/card-tantangan.vue";

const listTantangan = ref([]);
const tantanganSearch = ref("");
const isSearching = ref(true);
const page = ref(1);
const links = ref([]);

const searchTantangan = async () => {
	try {
		isSearching.value = true;

		const results = await getListTantangan({
			page: page.value,
			search: tantanganSearch.value,
		})

		listTantangan.value = results.data;
		links.value = results.links;
		page.value = results.current_page;
	} catch (error) {
		await Swal.fire({
			icon: 'error',
			title: 'Gagal mengambil data tantangan resleting!',
			text: getErrorMessage(error, 'Gagal mengambil data tantangan resleting!'),
		})
	} finally {
		isSearching.value = false;
	}
}

const debouncedSearchTantangan = debounce(searchTantangan, 350)

const changeTantanganPage = newPage => {
	page.value = newPage;
	searchTantangan();
}

onMounted(searchTantangan)
watch(tantanganSearch, debouncedSearchTantangan)
watch(tantanganSearch, () => page.value = 1)
</script>

<template>
	<VRow>
		<VCol cols="12">
			<VTextField v-model="tantanganSearch" prepend-inner-icon="bx-search" label="Cari tantangan" />
		</VCol>
	</VRow>

	<VRow v-if="!isSearching">
		<VCol v-for="(tantangan, index) in listTantangan" :key="index" cols="12" sm="6" md="4">
			<CardTantangan :to="`/admin/layanan/resleting/tantangan/${tantangan.id}`" :data-tantangan="tantangan" />
		</VCol>
		<VCol v-if="listTantangan.length === 0">
			<p class="text-center">Belum ada tantangan atau tidak ada hasil yang sesuai.</p>
		</VCol>
	</VRow>
	<VRow v-else>
		<VProgressCircular indeterminate color="primary" class="mt-5 mx-auto" size="50">
		</VProgressCircular>
	</VRow>


	<VRow>
		<VCol cols="12">
			<VPagination v-model="page" :total-visible="6" :disabled="isSearching" size="x-large" :length="links.length - 2"
				@update:model-value="changeTantanganPage" />
		</VCol>
	</VRow>
</template>