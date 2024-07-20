<script setup>
import { onMounted, ref, watch } from "vue"
import debounce from "just-debounce";
import HistorySuratTugasItem from "./history-surat-tugas-item.vue";
import { getListSuratTugas } from "../../api/surat-tugas-api";
import Swal from "sweetalert2";
import { getErrorMessage } from "@/utils/get-error-message";

const listHistorySurat = ref([]);
const historySearch = ref("");
const isSearching = ref(true);
const page = ref(1);
const links = ref([]);

const searchHistory = async () => {
	try {
		isSearching.value = true;

		const results = await getListSuratTugas({
			page: page.value,
			search: historySearch.value,
		})

		listHistorySurat.value = results.data;
		links.value = results.links;
	} catch (error) {
		await Swal.fire({
			icon: 'error',
			title: 'Gagal mengambil data histori surat tugas!',
			text: getErrorMessage(error, 'Gagal mengambil data histori surat tugas!'),
		})
	} finally {
		isSearching.value = false;
	}
}

const debouncedSearchHistory = debounce(searchHistory, 350)

const changeHistoryPage = newPage => {
	page.value = newPage;
	searchHistory();
}

onMounted(searchHistory)
watch(historySearch, debouncedSearchHistory)
watch(historySearch, () => page.value = 1)
</script>

<template>
	<VRow>
		<VCol cols="12">
			<VTextField v-model="historySearch" prepend-inner-icon="bx-search" label="Cari Histori Surat" />
		</VCol>
	</VRow>

	<VRow v-if="!isSearching">
		<VCol v-for="surat in listHistorySurat" :key="surat.id" cols="12" sm="6" md="4" lg="3">
			<HistorySuratTugasItem :surat="surat" />
		</VCol>
		<VCol v-if="listHistorySurat.length === 0">
			<p class="text-center">Belum ada histori surat tugas atau tidak ada hasil yang sesuai.</p>
		</VCol>
	</VRow>
	<VRow v-else>
		<VProgressCircular indeterminate color="primary" class="mt-5 mx-auto" size="50">
		</VProgressCircular>
	</VRow>

	<VRow>
		<VCol cols="12">
			<VPagination v-model="page" :total-visible="6" :disabled="isSearching" size="x-large" :length="links.length - 2"
				@update:model-value="changeHistoryPage"></VPagination>
		</VCol>
	</VRow>
</template>