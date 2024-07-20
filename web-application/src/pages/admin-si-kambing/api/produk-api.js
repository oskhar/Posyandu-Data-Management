import { api } from "@/lib/api";
import { getFullImagePath } from "@/utils/get-full-image-path";
import { useProdukStore } from "@/utils/kambing-fake-store";

export const getListProduk = async ({
	page = 1,
	search = "",
	lengthPerPage = 6,
	tags = [],
}) => {
	const { data } = await api.get("/produk", {
		params: { search, length: lengthPerPage, page, tags, sort: "terbaru" },
	});

	/** @type {import("./types").ProductResponse} */
	const dataResponse = data;

  dataResponse.data = dataResponse.data.map(item => ({ ...item, gambar: getFullImagePath(item.gambar) }));

  return dataResponse;
}

export const getDetailProduk = async id => {
	const parsedId = parseInt(id);
	
	const { data } = await api.get(`/produk/${parsedId}`);

	 data.gambar = getFullImagePath( data.gambar);
	 data.sedang_dijual = data.sedang_dijual === 1;
	 data.pin = data.pin === 1;

	return data
}

/**
 * @param {import("./types").CreateProduk} produk 
 */
export const createProduk = async produk => {
	const { data } = await api.post(`/produk`, produk);

	return data
}


/**
 * @param {string} id 
 * @param {import("./types").CreateProduk} produk 
 */
export const editProduk = async (id, produk) => {
	const idProduk = parseInt(id);

	const { data } = await api.put(`/produk/${idProduk}`, produk);

	return data
}

/**
 * @param {string} id 
 */
export const deleteProduk = async id => {
	const idProduk = parseInt(id);

	const { data } = await api.delete(`/produk/${idProduk}`);

	return data
}

export const getTags = async () => {
	const { data } = await api.get("/produk/tags");

	return data
}