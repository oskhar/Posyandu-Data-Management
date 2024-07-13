<script setup>
import { ref, watch } from "vue"
import debounce from "just-debounce";
import DraftSuratTugasItem from "./draft-surat-tugas-item.vue";
import { getListDraftSuratTugas } from "../../api/draft-surat-tugas-api";
import Swal from "sweetalert2";
import { getErrorMessage } from "@/utils/get-error-message";
import { deleteDraftSuratTugasHandler, editDraftSuratTugasHandler } from "../../handlers/draft-surat-tugas-handler";

const drafts = ref([]);
const draftSearch = ref("");
const isSearching = ref(true);
const page = ref(1);
const links = ref([]);

const searchDrafts = async () => {
	try {
		isSearching.value = true;

		const results = await getListDraftSuratTugas({
			page: page.value,
			search: draftSearch.value,
			length: 16,
		})

		drafts.value = results.data;
		links.value = results.links;
		page.value = results.current_page;
	} catch (error) {
		await Swal.fire({
			icon: 'error',
			title: 'Gagal mengambil data draft surat tugas!',
			text: getErrorMessage(error, 'Gagal mengambil data draft surat tugas!'),
		})
	} finally {
		isSearching.value = false;
	}
}

const debouncedSearchDrafts = debounce(searchDrafts, 350)

const changeDraftPage = newPage => {
	page.value = newPage;
	searchDrafts();
}

onMounted(searchDrafts)
watch(draftSearch, debouncedSearchDrafts)


// draft handlers
const editDraftSurat = async editedDraft => {
	try {
		await editDraftSuratTugasHandler(editedDraft, searchDrafts);

		await searchDrafts();
	} catch (error) {
		await Swal.fire({
			icon: 'error',
			title: 'Gagal mengedit draft surat tugas!',
			text: getErrorMessage(error, 'Gagal mengedit draft surat tugas!'),
		});
	}
}

const deleteDraftSurat = async draftId => {
	try {
		await deleteDraftSuratTugasHandler(draftId);

		await Swal.fire({
			icon: 'success',
			title: 'Berhasil menghapus draft surat tugas!',
		})

		await searchDrafts();
	} catch (error) {
		await Swal.fire({
			icon: 'error',
			title: 'Gagal mengedit draft surat tugas!',
			text: getErrorMessage(error, 'Gagal mengedit draft surat tugas!'),
		});
	}
}
</script>

<template>
	<VRow>
		<VCol cols="12">
			<VTextField v-model="draftSearch" prepend-inner-icon="bx-search" label="Cari Draft Surat" />
		</VCol>
	</VRow>

	<VRow v-if="!isSearching">
		<VCol v-for="draft in drafts" :key="draft.nomor" cols="12" sm="6" md="4" lg="3">
			<DraftSuratTugasItem :draft="draft" @edit-draft="editDraftSurat" @delete-draft="deleteDraftSurat" />
		</VCol>
		<VCol v-if="drafts.length === 0">
			<p class="text-center">Belum ada draft surat tugas atau tidak ada hasil yang sesuai.</p>
		</VCol>
	</VRow>
	<VRow v-else>
		<VProgressCircular indeterminate color="primary" class="mt-5 mx-auto" size="50">
		</VProgressCircular>
	</VRow>


	<VRow>
		<VCol cols="12">
			<VPagination size="x-large" :length="links.length - 2" @update:model-value="changeDraftPage" />
		</VCol>
	</VRow>
</template>