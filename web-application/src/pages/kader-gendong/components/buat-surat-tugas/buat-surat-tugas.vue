<script setup>
import Swal from "sweetalert2";
import { suratTugasValidator } from '../../validators/surat-tugas-validator';
import { getErrorMessage } from '@/utils/get-error-message';
import { mysqlDateTime } from '@/utils/mysql-datetime';
import FormSuratTugas from '../form-surat-tugas.vue';

const emit = defineEmits(['create', "createDraft"])

const emitCreateSuratTugas = async suratData => {
	try {
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
			emit("create", parsedSurat);
		}
	} catch (error) {
		await Swal.fire({
			icon: 'error',
			title: 'Input Tidak Valid',
			html: `<pre>${getErrorMessage(error, 'Gagal membuat surat tugas!')}</pre>`,
		})
	}
};

const emitCreateDraftSuratTugas = async suratData => {
	try {
		const rawSurat = {
			...suratData,
			tanggal_surat: mysqlDateTime(suratData.tanggal_surat),
		}

		const parsedSurat = await suratTugasValidator.parseAsync(rawSurat)

		emit("createDraft", parsedSurat);

		await Swal.fire({
			icon: 'success',
			title: 'Draft surat berhasil disimpan',
		})
	} catch (error) {
		await Swal.fire({
			icon: 'error',
			title: 'Input Tidak Valid',
			html: `<pre>${getErrorMessage(error, 'Gagal membuat draft surat tugas!')}</pre>`,
		})
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
