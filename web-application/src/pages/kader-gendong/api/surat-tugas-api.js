import { api } from "@/lib/api"

export const getListSuratTugas = async ({
	search = "",
	length = 16,
	page = 1,
}) => {
	const { data } = await api.get("/kader-gendong", {
		params: {	search, length,	page },
	})

	return data.success
}

/**
 * @param {*} surat 
 * @returns {{ message: string; file: string }} File is in base64
 */
export const createSuratTugas = async surat => {
	const { data } = await api.post("/kader-gendong", surat)

	return data.success;
}

