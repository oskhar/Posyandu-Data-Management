import Swal from "sweetalert2";
import { getErrorMessage } from "@/utils/get-error-message";
import { createTantangan } from "../api/resliting-admin-api";

export const createTantanganHandler = async tantangan => {
	try {
		const result = await createTantangan(tantangan);

		await Swal.fire({
			icon: 'success',
			title: 'Berhasil membuat tantangan',
			text: result.message,
		});
	} catch (error) {
		await Swal.fire({
			icon: 'error',
			title: 'Gagal membuat tantangan',
			text: getErrorMessage(error, 'Gagal membuat tantangan!'),
		});
	}
};
