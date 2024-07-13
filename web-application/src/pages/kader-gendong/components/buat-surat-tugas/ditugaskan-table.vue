<script setup>
import Swal from "sweetalert2";
import { computed, ref } from 'vue';
import { ditugaskanValidator } from "../../validators/surat-tugas-validator";
import { getErrorMessage } from "@/utils/get-error-message";

const { listDitugaskan, onAdd, onDelete } = defineProps({
	listDitugaskan: { type: Array, required: true },
})

const emit = defineEmits(['addToTable', 'deleteFromTable']);

// New data input refs
const nama = ref('');
const jabatan = ref('');
const alamat = ref('');

const isAddingToTable = ref(false);
const isInputNotValid = computed(() => !nama.value.trim() || !jabatan.value.trim() || !alamat.value.trim());


const emitAddToTable = async () => {
	try {
		isAddingToTable.value = true;
		if (isInputNotValid.value) {
			return;
		}


		const parsedOrang = await ditugaskanValidator.parseAsync({
			nama: nama.value,
			jabatan: jabatan.value,
			alamat: alamat.value,
		})

		emit("addToTable", parsedOrang);

		nama.value = '';
		jabatan.value = '';
		alamat.value = '';

	} catch (error) {
		await Swal.fire({
			icon: 'error',
			title: 'Input Tidak Valid',
			text: getErrorMessage(error, 'Nama, jabatan, dan alamat harus diisi!'),
		})
	} finally {
		isAddingToTable.value = false;
	}
}

const emitDeleteFromTable = rowIndex => {
	emit("deleteFromTable", rowIndex);
} 
</script>

<template>
	<VTable class="rounded border-thin">
		<thead>
			<tr>
				<th class="text-left">
					Nama
				</th>
				<th class="text-left">
					Jabatan
				</th>
				<th class="text-left">
					Alamat
				</th>
				<th class="text-left">
					Aksi
				</th>
			</tr>
		</thead>
		<tbody>
			<tr v-for="([index, orang]) in Object.entries(listDitugaskan)" :key="index">
				<td>{{ orang.nama }}</td>
				<td>{{ orang.jabatan }}</td>
				<td>{{ orang.alamat }}</td>
				<td class="text-center">
					<VBtn color="error" @click="emitDeleteFromTable(parseInt(index))">
						<VIcon icon="bx-trash" start />
						Hapus
					</VBtn>
				</td>
			</tr>
			<tr v-if="listDitugaskan.length === 0">
				<td class="text-center pa-2" colspan="4">
					Belum ada yang ditugaskan
				</td>
			</tr>

			<tr>
				<td class="py-4">
					<VTextField v-model="nama" class="pa-0" label="Nama..." variant="plain"></VTextField>
				</td>
				<td class="py-4">
					<VTextField v-model="jabatan" class="pa-0" label="Jabatan..." variant="plain"></VTextField>
				</td>
				<td class="py-4">
					<VTextField v-model="alamat" class="pa-0" label="Alamat..." variant="plain"></VTextField>
				</td>
				<td class="text-center">
					<VBtn :disabled="isInputNotValid || isAddingToTable" @click="emitAddToTable">
						<VIcon icon="bx-user-plus" start />
						Tambah
					</VBtn>
				</td>
			</tr>
		</tbody>
	</VTable>
</template>