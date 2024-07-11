<script setup>
import { ref, watch } from "vue"
import debounce from "just-debounce";
import DraftSuratTugasItem from "./draft-surat-tugas-item.vue";


const listPenandaTangan = ref(['California', 'Colorado', 'Florida', 'Georgia', 'Texas', 'Wyoming']);

const drafts = ref(Array.from({ length: 20 }, (_, i) => (
	{
		id: i,
		penanda_tangan: listPenandaTangan.value[0],
		tanggal_surat: new Date(),
		nomor: 'SPK/X/VII/2024',
		kalimat_pembuka: '<p>Kalimat pembuka goes here</p>',
		ditugaskan: [],
		isi_surat: '<p>Lorem ipsum dolor sit, amet consectetur adipisicing elit. Amet deserunt quae molestias, natus modi dolor corporis error dignissimos porro eligendi voluptate at dolores soluta velit explicabo repudiandae optio, sapiente ab alias? Architecto inventore in voluptatum consequatur, autem necessitatibus adipisci deleniti.</p>',
		kalimat_penutup: '<p>Kalimat penutup goes here</p>',
	}
)));

const draftSearch = ref("");
const isSearching = ref(false);
const page = ref(1);

const searchDraft = debounce(() => {
	isSearching.value = false;

}, 350)

const changeDraftPage = newPage => {
	page.value = page;
}

watch(draftSearch, () => {
	isSearching.value = true;
	searchDraft()
})
</script>

<template>
	<VRow>
		<VCol cols="12">
			<VTextField v-model="draftSearch" append-inner-icon="bx-search" label="Cari Draft Surat" />
		</VCol>
	</VRow>
	<VRow>
		<VCol v-for="draft in drafts" :key="draft.id" cols="12" sm="6" md="4" lg="3">
			<DraftSuratTugasItem :draft="draft" :list-penanda-tangan="listPenandaTangan" />
		</VCol>
	</VRow>

	<VRow>
		<VCol cols="12">
			<VPagination size="x-large" :length="4" @update:model-value="changeDraftPage"></VPagination>
		</VCol>
	</VRow>
</template>