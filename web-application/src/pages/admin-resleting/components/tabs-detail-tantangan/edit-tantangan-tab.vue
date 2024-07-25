<script setup>
import { getSwalErrorMessage } from '@/utils/get-error-message';
import CreateTantanganForm from '../create-tantangan-form.vue';
import { mysqlDateTime } from '@/utils/mysql-datetime';
import Swal from 'sweetalert2';
import { tantanganValidator } from '../../validators/tantangan-validator';
import { deleteTantangan, editListTantangan, getSingleTantangan } from '../../api/tantangan-api';
import { DEFAULT_TANTANGAN } from '@/constants';
import { ref } from 'vue';
import { useRouter } from 'vue-router';

const route = useRoute();
const router = useRouter()
const isLoading = ref(true);
const dataTantangan = ref(DEFAULT_TANTANGAN)

const fetchData = async () => {
	try {
		isLoading.value = true

		const idTantangan = route.params.id

		const result = await getSingleTantangan(idTantangan)

		dataTantangan.value = {
			...result,
			tanggal_mulai: new Date(result.tanggal_mulai),
			tanggal_selesai: new Date(result.tanggal_selesai),
		}


	} catch (error) {
		await Swal.fire({
			icon: "error",
			html: getSwalErrorMessage(error, "Terjadi kesalahan saat loading data tantangan!"),
			showCloseButton: true,
		});

		router.push("/admin/layanan/resleting/tantangan")
	} finally {
		isLoading.value = false
	}
}


const handleEditTantangan = async (tantanganData, isEditingTantangan) => {
	try {
		isEditingTantangan.value = true;

		const rawTantangan = {
			...tantanganData,
			tanggal_mulai: mysqlDateTime(tantanganData.tanggal_mulai),
			tanggal_selesai: mysqlDateTime(tantanganData.tanggal_selesai),
		}

		const parsedTantangan = await tantanganValidator.parseAsync(rawTantangan)

		const { isConfirmed } = await Swal.fire({
			title: 'Edit Tantangan',
			text: 'Apakah Anda yakin ingin mengubah tantangan ini?',
			icon: 'question',
			showCancelButton: true,
			showConfirmButton: true,
		});

		if (isConfirmed) {
			const idTantangan = route.params.id;

			await editListTantangan(idTantangan, parsedTantangan);

			await Swal.fire({
				icon: 'success',
				title: 'Berhasil mengubah tantangan',
			});
		}

	} catch (error) {
		await Swal.fire({
			icon: 'error',
			title: 'Input Tidak Valid',
			html: getSwalErrorMessage(error, 'Gagal mengubah tantangan!'),
		})
	} finally {
		isEditingTantangan.value = false;
	}
}

const handleDeleteTantangan = async () => {
	try {
		const { isConfirmed } = await Swal.fire({
			title: 'Hapus Tantangan',
			text: 'Apakah Anda yakin ingin menghapus tantangan ini?',
			icon: 'question',
			showCancelButton: true,
			showConfirmButton: true,
		});

		if (isConfirmed) {
			const idTantangan = route.params.id;

			await deleteTantangan(idTantangan);

			await Swal.fire({
				icon: 'success',
				title: 'Berhasil menghapus tantangan',
			});

			router.push("/admin/layanan/resleting/tantangan")
		}

	} catch (error) {
		await Swal.fire({
			icon: 'error',
			title: 'Gagal menghapus tantangan',
			html: getSwalErrorMessage(error, 'Gagal menghapus tantangan!'),
		})
	}
}

onMounted(fetchData)
</script>

<template>
	<VSkeletonLoader v-if="isLoading" type="article" />
	<CreateTantanganForm v-else main-action-title="Edit Tantangan"
		:title="`Edit tantangan ${dataTantangan.judul || '...'}`" :tantangan="dataTantangan"
		@create-tantangan="handleEditTantangan">

		<VBtn color="error" @click="handleDeleteTantangan">Hapus Tantangan</VBtn>
	</CreateTantanganForm>
</template>
