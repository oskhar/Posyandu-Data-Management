<script setup>
import { getSwalErrorMessage } from '@/utils/get-error-message';
import { getSubmissions } from '../../api/submissions-api';
import { createDownload } from '@/utils/file';
import Swal from 'sweetalert2';
import debounce from 'just-debounce';
import { onMounted, ref, watch } from 'vue';
import SubmissionActionDialog from './submission-action-dialog.vue';
import { getFullImagePath } from '@/utils/get-full-image-path';

const { tantanganId } = defineProps({
	tantanganId: { type: String, required: true },
})

const lengthPerPage = ref(6);

const listSubmission = ref([]);
const submissionSearch = ref("");
const isSearching = ref(true);
const page = ref(1);
const pageAmount = ref(1);

const searchSubmission = async () => {
	try {
		isSearching.value = true;

		const results = await getSubmissions({
			tantanganId,
			page: page.value,
			search: submissionSearch.value,
			lengthPerPage: lengthPerPage.value,
		});

		listSubmission.value = results.data;
		pageAmount.value = results.links - 2;
		page.value = results.current_page;
	} catch (error) {
		await Swal.fire({
			icon: 'error',
			title: 'Gagal mengambil data submission!',
			html: getSwalErrorMessage(error, 'Gagal mengambil data submission!'),
		});
	} finally {
		isSearching.value = false;
	}
};

const debouncedSearchSubmission = debounce(searchSubmission, 350);

const changeSubmissionPage = newPage => {
	page.value = newPage;
	searchSubmission();
};


onMounted(searchSubmission);
watch(submissionSearch, debouncedSearchSubmission);
watch(submissionSearch, () => page.value = 1);
</script>

<template>
	<VRow class="mb-4">
		<VCol cols="12">
			<VTextField v-model="submissionSearch" prepend-inner-icon="bx-search" label="Cari submission" />
		</VCol>
	</VRow>

	<VTable class="rounded-lg text-center h-100">
		<thead>
			<tr>
				<th>No</th>
				<th>File</th>
				<th>Link</th>
				<th>Peringkat (1 - 3)</th>
				<th>Aksi</th>
			</tr>
		</thead>
		<tbody>
			<tr v-for="(submission, index) in listSubmission" :key="index" height=" 75">
				<td>{{ index + 1 + ((page - 1) * lengthPerPage) }}</td>
				<td>
					<VBtn v-if="submission.file" prepend-icon="bx-download"
						@click="createDownload(getFullImagePath(submission.file), submission.file.split('/')[3])">
						Download file
					</VBtn>
					<span v-else>
						Tidak ada file
					</span>
				</td>
				<td>
					<VBtn v-if="submission.link" prepend-icon="bx-link" target="__blank" :href="submission.link">
						Lihat link
					</VBtn>
					<span v-else>
						Tidak ada link
					</span>
				</td>
				<td>
					{{ submission.peringkat || 'Tidak Juara' }}
				</td>
				<td>
					<SubmissionActionDialog :tantangan-id="tantanganId" :submission="submission"
						@update-submission="searchSubmission" />
				</td>
			</tr>
			<tr v-if="listSubmission.length === 0">
				<td colspan="5">Belum ada submission</td>
			</tr>
		</tbody>
	</VTable>

	<VRow class="mt-4">
		<VCol cols="12">
			<VPagination v-model="page" :total-visible="6" :disabled="isSearching" size="x-large" :length="pageAmount"
				@update:model-value="changeSubmissionPage" />
		</VCol>
	</VRow>
</template>
