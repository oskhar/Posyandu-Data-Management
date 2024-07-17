<script setup>
import { mysqlDateTime } from '@/utils/mysql-datetime';
import CreateTantanganForm from '../create-tantangan-form.vue';
import Swal from 'sweetalert2';
import { createTantanganHandler } from '../../handlers/tantangan-handler';
import { tantanganValidator } from '../../validators/tantangan-validator';
import { getSwalErrorMessage } from '@/utils/get-error-message';


const createTantangan = async (tantanganData, isCreatingTantangan, resetFormTantangan) => {
	try {
		isCreatingTantangan.value = true;

		const rawTantangan = {
			...tantanganData,
			tanggal_mulai: mysqlDateTime(tantanganData.tanggal_mulai),
			tanggal_selesai: mysqlDateTime(tantanganData.tanggal_selesai),
		}

		const parsedTantangan = await tantanganValidator.parseAsync(rawTantangan)

		const { isConfirmed } = await Swal.fire({
			title: 'Buat Tantangan',
			text: 'Apakah Anda yakin ingin membuat tantangan ini?',
			icon: 'question',
			showCancelButton: true,
			showConfirmButton: true,
		});

		if (isConfirmed) {
			await createTantanganHandler(parsedTantangan);
			resetFormTantangan()
		}

	} catch (error) {
		await Swal.fire({
			icon: 'error',
			title: 'Input Tidak Valid',
			html: getSwalErrorMessage(error, 'Gagal membuat surat tugas!'),
		})
	} finally {
		isCreatingTantangan.value = false;
	}
}
</script>

<template>
	<CreateTantanganForm @create-tantangan="createTantangan" />
</template>