<script setup>
import { ref, reactive, onMounted } from 'vue';
import { useRoute, useRouter } from 'vue-router';
import Swal from 'sweetalert2';
import { getErrorMessage, getSwalErrorMessage } from '@/utils/get-error-message';
import CreateProdukForm from './components/create-produk-form.vue';
import { deleteProduk, editProduk, getDetailProduk } from './api/produk-api';


const router = useRouter();
const route = useRoute();
const isLoading = ref(true);

const dataProduk = reactive({});

async function fetchData() {
	try {
		isLoading.value = true;

		const idProduk = route.params.id;

		const fetchedData = await getDetailProduk(idProduk);

		Object.assign(dataProduk, fetchedData);
	} catch (error) {
		await Swal.fire({
			icon: "error",
			text: getErrorMessage(error, "Terjadi kesalahan saat loading data produk!"),
			showCloseButton: true,
		});

		router.push("/admin/layanan/si-kambing");
	} finally {
		isLoading.value = false;
	}
}

async function handleEditProduk(produkData, isEditingProduk) {
	try {
		isEditingProduk.value = true;

		const { isConfirmed } = await Swal.fire({
			title: 'Edit Produk',
			icon: 'question',
			text: 'Apakah Anda ingin mengubah data produk ini?',
			showConfirmButton: true,
		})


		if (isConfirmed) {
			const idProduk = route.params.id;

			await editProduk(idProduk, produkData);
			await Swal.fire({
				icon: 'success',
				title: 'Berhasil mengubah data produk!',
				showCloseButton: true,
			});
		}
	} catch (error) {
		await Swal.fire({
			icon: 'error',
			text: getErrorMessage(error, 'Gagal mengubah data produk!'),
			showCloseButton: true,
		});
	} finally {
		isEditingProduk.value = false;
	}
}


const handleDeleteProduk = async () => {
	try {
		const { isConfirmed } = await Swal.fire({
			title: 'Hapus Produk',
			text: 'Apakah Anda yakin ingin menghapus produk ini?',
			icon: 'question',
			showCancelButton: true,
			showConfirmButton: true,
		});

		if (isConfirmed) {
			const idProduk = route.params.id;

			await deleteProduk(idProduk);

			await Swal.fire({
				icon: 'success',
				title: 'Berhasil menghapus produk',
			});

			router.push("/admin/layanan/si-kambing")
		}

	} catch (error) {
		await Swal.fire({
			icon: 'error',
			title: 'Gagal menghapus produk',
			html: getSwalErrorMessage(error, 'Gagal menghapus produk!'),
		})
	}
}


onMounted(fetchData);
</script>

<template>
	<VBtn prepend-icon="bx-left-arrow-alt" variant="text" to="/admin/layanan/si-kambing" class="mb-4">
		Kembali
	</VBtn>

	<CreateProdukForm :produk="dataProduk" title="Form Edit Produk" main-action-title="Edit Produk"
		@create-produk="handleEditProduk">

		<VBtn color="error" @click="handleDeleteProduk">Hapus Produk</VBtn>
	</CreateProdukForm>
</template>
