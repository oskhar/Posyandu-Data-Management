<script setup>
import { getSwalErrorMessage } from '@/utils/get-error-message';
import { editFeedback, getSubmissions } from '../../api/submissions-api';
import { createDownload } from '@/utils/file';
import Swal from 'sweetalert2';
import debounce from 'just-debounce';
import { onMounted, ref, watch, computed } from 'vue';

const { tantanganId } = defineProps({
	tantanganId: { type: String, required: true },
})

const lengthPerPage = ref(6);

const listSubmission = ref([]);
const submissionSearch = ref("");
const isSearching = ref(true);
const page = ref(1);
const links = ref([]);
const pickedJuara = ref([]);

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
		links.value = results.links;
		page.value = results.current_page;
		pickedJuara.value = listSubmission.value.map(submission => ({ juara: null, submission }));
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

const handleJuaraChange = (value, index, submission) => {
	const parsedValue = parseInt(value);

	if (isNaN(parsedValue) || parsedValue < 1 || parsedValue > 3) {
		pickedJuara.value[index] = { juara: null, submission };

		return;
	}

	const pickedValues = pickedJuara.value.filter((v, i) => i !== index).map(v => v.juara);
	if (pickedValues.includes(parsedValue)) {
		pickedJuara.value[index] = { juara: null, submission };
		Swal.fire({
			icon: 'error',
			title: 'Angka juara sudah dipilih!',
		});
	} else {
		pickedJuara.value[index] = { juara: parsedValue, submission };
	}
};

const handleSaveChanges = async submissionId => {
	const { isConfirmed } = await Swal.fire({
		title: 'Simpan Perubahan',
		text: 'Apakah Anda yakin ingin menyimpan perubahan?',
		icon: 'question',
		showCancelButton: true,
		showConfirmButton: true,
	});


	if (isConfirmed) {
		await editFeedback(submissionId, {
			feedback: "",
			peringkat: pickedJuara.value.find(val => val.submission.id === submissionId).juara,
		});

		await Swal.fire({
			icon: 'success',
			title: 'Berhasil menyimpan perubahan',
		});

	}
}

const allNumbersPicked = computed(() => {
	const pickedValues = pickedJuara.value.filter(val => val.juara !== null).map(val => val.juara);

	return [1, 2, 3].every(num => pickedValues.includes(num));
});

const rowHasJuara = computed(() => {
	return listSubmission.value.map((_, index) => pickedJuara.value[index].juara !== null);
});

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
				<th>Juara</th>
				<th>Aksi</th>
			</tr>
		</thead>
		<tbody>
			<tr v-for="(submission, index) in listSubmission" :key="index" :class="{ 'bg-primary-faded': rowHasJuara[index] }"
				height="75">
				<td>{{ index + 1 + ((page - 1) * lengthPerPage) }}</td>
				<td>
					<VBtn v-if="submission.file" prepend-icon="bx-download"
						@click="createDownload(submission.file, 'application/x-zip', 'zip')">
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
					<VTextField v-model="pickedJuara[index].juara" label='Juara (1 - 3)' style="max-width: 150px;" class="mx-auto"
						:min="1" :max="3" :disabled="pickedJuara[index].juara === null && allNumbersPicked"
						@change="handleJuaraChange($event.target.value, index, submission)" />
				</td>
				<td>
					<VBtn prepend-icon="bx-save" @click="handleSaveChanges(submission.id)">Simpan Perubahan</VBtn>
				</td>
			</tr>
			<tr v-if="listSubmission.length === 0">
				<td colspan="5">Belum ada submission</td>
			</tr>
		</tbody>
	</VTable>

	<VRow class="mt-4">
		<VCol cols="12">
			<VPagination v-model="page" :total-visible="6" :disabled="isSearching" size="x-large" :length="links.length - 2"
				@update:model-value="changeSubmissionPage" />
		</VCol>
	</VRow>
</template>
