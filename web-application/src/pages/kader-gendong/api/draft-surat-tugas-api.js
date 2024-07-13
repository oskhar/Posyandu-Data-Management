import { api } from "@/lib/api"

/**
 * @param {{search: string; length: number; page: number}} param0 
 * @returns {import("./types").KaderGendongResponse}
 */
export const getListDraftSuratTugas = async ({
	search = "",
	length = 8,
	page = 1,
}) => {
	const { data } = await api.get("/kader-gendong/draf", {
		params: {	search, length,	page },
	})

	return data;
}

export const createDraftSuratTugas = async surat => {
	const { data } = await api.post("/kader-gendong/draf", surat);
	
	return data;
}

export const editDraftSuratTugas = async (id, surat) => {
	const { data } = await api.put(`/kader-gendong/draf/${id}`, surat);
 	
	return data;
}

export const deleteDraftSuratTugas = async id => {
	const { data } = await api.delete(`/kader-gendong/draf/${id}`);
 	
	return data;
}

export const cetakDraftSuratTugas = async id => {
	const { data } = await api.delete(`/kader-gendong/draf/cetak/${id}`);
 	
	return data;
}