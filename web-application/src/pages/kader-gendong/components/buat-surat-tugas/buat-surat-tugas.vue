<script setup>
import Swal from "sweetalert2";
import { suratTugasValidator } from '../../validators/surat-tugas-validator';
import { getErrorMessage } from '@/utils/get-error-message';
import { mysqlDateTime } from '@/utils/mysql-datetime';
import FormSuratTugas from '../form-surat-tugas.vue';
import { createSuratTugasHandler } from "../../handlers/surat-tugas-handler";
import { createDraftSuratTugasHandler } from "../../handlers/draft-surat-tugas-handler";


const emitCreateSuratTugas = async (suratData, isCreatingSuratTugas, resetFormSuratTugas) => {
	try {
		isCreatingSuratTugas.value = true;

		const rawSurat = {
			...suratData,
			tanggal_surat: mysqlDateTime(suratData.tanggal_surat),
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
			await createSuratTugasHandler(parsedSurat);
			resetFormSuratTugas()
		}

	} catch (error) {
		await Swal.fire({
			icon: 'error',
			title: 'Input Tidak Valid',
			html: `<pre>${getErrorMessage(error, 'Gagal membuat surat tugas!')}</pre>`,
		})
	} finally {
		isCreatingSuratTugas.value = false;
	}
};

const emitCreateDraftSuratTugas = async (suratData, isCreatingDraftSuratTugas, resetFormSuratTugas) => {
	try {
		isCreatingDraftSuratTugas.value = true;

		const rawSurat = {
			...suratData,
			tanggal_surat: mysqlDateTime(suratData.tanggal_surat),
		}

		const parsedSurat = await suratTugasValidator.parseAsync(rawSurat)

		await createDraftSuratTugasHandler(parsedSurat)

		resetFormSuratTugas()

	} catch (error) {
		await Swal.fire({
			icon: 'error',
			title: 'Input Tidak Valid',
			html: `<pre>${getErrorMessage(error, 'Gagal membuat draft surat tugas!')}</pre>`,
		})
	} finally {
		isCreatingDraftSuratTugas.value = false;
	}
};
</script>

<template>
	<VRow>
		<VCol cols="12">
			<VCard>
				<FormSuratTugas @create="emitCreateSuratTugas" @create-draft="emitCreateDraftSuratTugas" />
			</VCard>
		</VCol>
	</VRow>
</template>
