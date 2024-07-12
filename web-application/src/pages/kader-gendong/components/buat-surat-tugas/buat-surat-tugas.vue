<script setup>
import Swal from "sweetalert2";
import { ref } from 'vue';
import { suratTugasValidator } from '../../validators';
import { getErrorMessage } from '@/utils/get-error-message';
import { mysqlDateTime } from '@/utils/mysql-datetime';
import FormSuratTugas from '../form-surat-tugas.vue';

const emit = defineEmits(['create'])

const listPenandaTangan = ref(['California', 'Colorado', 'Florida', 'Georgia', 'Texas', 'Wyoming']);

const handleCreateSuratTugas = async suratData => {
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
</script>

<template>
	<VRow>
		<VCol cols="12">
			<VCard>
				<FormSuratTugas :list-penanda-tangan="listPenandaTangan" @create="handleCreateSuratTugas" />
			</VCard>
		</VCol>
	</VRow>
</template>
