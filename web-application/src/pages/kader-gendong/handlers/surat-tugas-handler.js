import { createDownload } from "@/utils/create-download";
import Swal from "sweetalert2";
import { createSuratTugas, previewSuratTugas } from "../api/surat-tugas-api";
import { getErrorMessage } from "@/utils/get-error-message";

export const createSuratTugasHandler = async surat => {
	try {
		const result = await createSuratTugas(surat);

		createDownload(result.file);

		await Swal.fire({
			icon: 'success',
			title: 'Berhasil membuat surat',
			text: result.message,
		});
	} catch (error) {
		await Swal.fire({
			icon: 'error',
			title: 'Gagal membuat surat tugas',
			text: getErrorMessage(error, 'Gagal membuat surat tugas!'),
		});
	}
};


export const previewSuratTugasHandler = async surat => {
	try {
		return await previewSuratTugas(surat);
		
	} catch (error) {
		await Swal.fire({
			icon: 'error',
			title: 'Gagal mengambil preview surat tugas',
			text: getErrorMessage(error, 'Gagal mengambil preview surat tugas!'),
		});
	}
}