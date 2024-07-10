<script setup>
import DitugaskanTable from './ditugaskan-table.vue';
import Swal from "sweetalert2";
import { reactive, ref } from 'vue';
import { suratTugasValidator } from '../validators';
import { VTextField } from 'vuetify/lib/components/index.mjs';
import { QuillEditor } from '@vueup/vue-quill';
import { getErrorMessage } from '@/utils/get-error-message';

const { onCreate } = defineProps({
	onCreate: { type: Function, required: true },
})

const listPenandaTangan = ref(['California', 'Colorado', 'Florida', 'Georgia', 'Texas', 'Wyoming']);

const suratData = reactive({
	penanda_tangan: listPenandaTangan.value[0],
	tanggal_surat: new Date(),
	nomor: 'sk/123/123',
	kalimat_pembuka: 'halo',
	ditugaskan: [],
	isi_surat: 'nggak',
	kalimat_penutup: 'dsds',
})

const addDitugaskan = orang => suratData.ditugaskan.push(orang)

const deleteDitugaskan = index => {
	suratData.ditugaskan = suratData.ditugaskan.filter((_, i) => i !== index);
};

const handleCreateSuratTugas = async () => {
	try {

		const rawSurat = {
			...suratData,
			tanggal_surat: suratData.tanggal_surat.toISOString(),
		}


		const parsedSurat = await suratTugasValidator.parseAsync(rawSurat)

		const { isConfirmed } = await Swal.fire({
			icon: 'question',
			title: 'Yakin ingin membuat surat?',
			text: 'Pastikan data yang anda masukkan sudah benar sebelum mengkonfirmasi pembuatan surat.',
			showCancelButton: true,
			showConfirmButton: true,
		})

		if (isConfirmed) {
			onCreate(parsedSurat);
		}
	} catch (error) {
		await Swal.fire({
			icon: 'error',
			title: 'Input Tidak Valid',
			html: `<pre>${getErrorMessage(error, 'Gagal membuat surat tugas!')}</pre>`,
		})
	}
};
</script>

<template>
	<VRow>
		<VCol cols="12">
			<VCard>
				<VForm @submit.prevent="handleCreateSuratTugas">
					<VCardItem>
						<VCardTitle>
							Form Surat Tugas Posyandu
						</VCardTitle>
					</VCardItem>

					<VCardText>
						<!-- Penanda tangan dan tanggal surat -->
						<VRow>
							<VCol cols="12" md="8">
								<VCombobox v-model="suratData.penanda_tangan" :items="listPenandaTangan" label="Penanda Tangan"
									required />
							</VCol>

							<VCol cols="12" md="4">
								<VDateInput v-model="suratData.tanggal_surat" variant="outlined" label="Tanggal Surat" prepend-icon=""
									prepend-inner-icon="$calendar" />
							</VCol>
						</VRow>

						<!-- Nomor surat -->
						<VRow>
							<VCol cols="12">
								<VTextField v-model="suratData.nomor" label="Nomor Surat" required />
							</VCol>
						</VRow>

						<!-- Kalimat pembuka -->
						<VRow>
							<VCol cols="12">
								<h2 class="text-h6">Kalimat Pembuka</h2>
								<div style="min-height: 200px;" class="d-flex flex-column">
									<QuillEditor v-model:content="suratData.kalimat_pembuka" content-type="text"
										placeholder="Kalimat pembuka..." theme="snow" class="flex-fill" toolbar="essential" />
								</div>
							</VCol>
						</VRow>

						<!-- Ditugaskan -->
						<VRow>
							<VCol cols="12">
								<h2 class="text-h6">Orang Yang Ditugaskan</h2>
								<DitugaskanTable :on-add="addDitugaskan" :on-delete="deleteDitugaskan"
									:list-ditugaskan="suratData.ditugaskan" />
							</VCol>
						</VRow>

						<!-- Isi surat -->
						<VRow>
							<VCol cols="12">
								<h2 class="text-h6">Isi Surat</h2>
								<div style="min-height: 200px;" class="d-flex flex-column">
									<QuillEditor v-model:content="suratData.isi_surat" content-type="text" placeholder="Isi surat..."
										theme="snow" class="flex-fill" toolbar="essential" />
								</div>
							</VCol>
						</VRow>

						<!-- Kalimat penutup -->
						<VRow>
							<VCol cols="12">
								<h2 class="text-h6">Kalimat Penutup</h2>
								<div style="min-height: 200px;" class="d-flex flex-column">
									<QuillEditor v-model:content="suratData.kalimat_penutup" content-type="text"
										placeholder="Kalimat penutup..." theme="snow" class="flex-fill" toolbar="essential" />
								</div>
							</VCol>
						</VRow>
					</VCardText>

					<VCardActions>
						<VBtn color="primary" variant="flat" type="submit">
							Buat
						</VBtn>

						<VBtn color="primary" variant="outlined">
							Simpan Ke Draft
						</VBtn>

						<VBtn color="primary" variant="outlined">
							Review
						</VBtn>
					</VCardActions>
				</VForm>
			</VCard>
		</VCol>
	</VRow>
</template>
