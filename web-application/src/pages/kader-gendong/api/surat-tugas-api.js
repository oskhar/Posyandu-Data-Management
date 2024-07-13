import { api } from "@/lib/api"

/**
 * @param {{search: string; length: number; page: number}} param0 
 * @returns {import("./types").KaderGendongResponse}
 */
export const getListSuratTugas = async ({
	search = "",
	length = 8,
	page = 1,
}) => {
	const { data } = await api.get("/kader-gendong", {
		params: {	search, length,	page },
	})

	return data
}

/**
 * @param {*} surat 
 * @returns {{ message: string; file: string }} File is in base64
 */
export const createSuratTugas = async surat => {
	const { data } = await api.post("/kader-gendong", surat)

	return data.success;
}

/**
 * @param {*} surat 
 * @returns {{ message: string; file: string }} File is in base64
 */
export const previewSuratTugas = async surat => {
	const { data } = await api.post("/kader-gendong/preview", surat)

	return data;
}