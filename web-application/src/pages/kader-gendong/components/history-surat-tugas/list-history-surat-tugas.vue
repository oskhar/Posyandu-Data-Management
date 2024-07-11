<script setup>
import { ref, watch } from "vue"
import debounce from "just-debounce";
import HistorySuratTugasItem from "./history-surat-tugas-item.vue";

const listHistorySurat = ref(Array.from({ length: 20 }, () => (
	{
		id: crypto.randomUUID(),
		penanda_tangan: "California",
		tanggal_surat: new Date(),
		nomor: 'SPK/X/VII/2024',
		kalimat_pembuka: '<p>Kalimat pembuka goes here</p>',
		ditugaskan: [],
		isi_surat: '<p>Lorem ipsum dolor sit, amet consectetur adipisicing elit. Amet deserunt quae molestias, natus modi dolor corporis error dignissimos porro eligendi voluptate at dolores soluta velit explicabo repudiandae optio, sapiente ab alias? Architecto inventore in voluptatum consequatur, autem necessitatibus adipisci deleniti.</p>',
		kalimat_penutup: '<p>Kalimat penutup goes here</p>',
	}
)));


const historySearch = ref("");
const isSearching = ref(false);
const page = ref(1);

const searchHistory = debounce(() => {
	isSearching.value = false;
}, 350)

const changeHistoryPage = newPage => {
	console.log("🚀 ~ changeHistoryPage ~ newPage:", newPage)
	page.value = newPage;
}

watch(historySearch, () => {
	isSearching.value = true;
	searchHistory()
})
</script>

<template>
	<VRow>
		<VCol cols="12">
			<VTextField v-model="historySearch" prepend-inner-icon="bx-search" label="Cari Histori Surat" />
		</VCol>
	</VRow>
	<VRow>
		<VCol v-for="surat in listHistorySurat" :key="surat.id" cols="12" sm="6" md="4" lg="3">
			<HistorySuratTugasItem :surat="surat" />
		</VCol>
	</VRow>

	<VRow>
		<VCol cols="12">
			<VPagination size="x-large" :length="4" @update:model-value="changeHistoryPage"></VPagination>
		</VCol>
	</VRow>
</template>