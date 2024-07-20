<script setup>
import CreateProdukForm from '../create-produk-form.vue';
import Swal from 'sweetalert2';
import { produkValidator } from '../../validators/produk-validator';
import { getSwalErrorMessage } from '@/utils/get-error-message';
import { createProduk } from '../../api/produk-api';


const createProdukHandler = async (produkData, isCreatingProduk, resetFormTantangan) => {
	try {
		isCreatingProduk.value = true;

		const validatedProduk = await produkValidator.parseAsync(produkData)

		const { isConfirmed } = await Swal.fire({
			title: 'Buat Produk',
			text: 'Apakah Anda yakin ingin membuat produk ini?',
			icon: 'question',
			showCancelButton: true,
			showConfirmButton: true,
		});

		if (isConfirmed) {
			await createProduk(validatedProduk);
			await Swal.fire({
				icon: 'success',
				title: 'Berhasil membuat produk',
			});

			resetFormTantangan()
		}

	} catch (error) {
		await Swal.fire({
			icon: 'error',
			title: 'Gagal membuat produk',
			html: getSwalErrorMessage(error, 'Gagal membuat produk!'),
		})
	} finally {
		isCreatingProduk.value = false;
	}
}
</script>

<template>
	<CreateProdukForm @create-produk="createProdukHandler" />
</template>