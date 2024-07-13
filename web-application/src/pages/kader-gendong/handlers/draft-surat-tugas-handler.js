import Swal from "sweetalert2";
import { cetakDraftSuratTugas, createDraftSuratTugas, deleteDraftSuratTugas, editDraftSuratTugas } from "../api/draft-surat-tugas-api";
import { getErrorMessage } from "@/utils/get-error-message";

export const createDraftSuratTugasHandler = async surat => {
  try {
     await createDraftSuratTugas(surat);

    await Swal.fire({
      icon: 'success',
      title: 'Berhasil membuat draft surat tugas',
    });
  } catch (error) {
    await Swal.fire({
      icon: 'error',
      title: 'Gagal membuat draft surat tugas!',
      text: getErrorMessage(error, 'Gagal membuat draft surat tugas!'),
    });
  }
};

export const editDraftSuratTugasHandler = async editedDraft => {
	try {
		await editDraftSuratTugas(editedDraft.id, editedDraft);

		await Swal.fire({
      icon: 'success',
      title: 'Berhasil mengedit draft surat tugas',
    });
	} catch (error) {
		await Swal.fire({
			icon: 'error',
			title: 'Gagal mengedit draft surat tugas!',
			text: getErrorMessage(error, 'Gagal mengedit draft surat tugas!'),
		});
	}
};

export const deleteDraftSuratTugasHandler = async draftId => {
	try {
		await deleteDraftSuratTugas(draftId);

		await Swal.fire({
      icon: 'success',
      title: 'Berhasil menghapus draft surat tugas',
    });
	} catch (error) {
		await Swal.fire({
			icon: 'error',
			title: 'Gagal menghapus draft surat tugas!',
			text: getErrorMessage(error, 'Gagal menghapus draft surat tugas!'),
		});
	}
};

export const cetakDraftSuratTugasHandler = async suratId => {
  try {
     await cetakDraftSuratTugas(suratId);

    await Swal.fire({
      icon: 'success',
      title: 'Berhasil mencetak surat tugas dari draft ini',
    });
  } catch (error) {
    await Swal.fire({
      icon: 'error',
      title: 'Gagal mencetak surat tugas dari draft ini!',
      text: getErrorMessage(error, 'Gagal mencetak surat tugas dari draft ini!'),
    });
  }
};
