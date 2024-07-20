import { api } from "@/lib/api";
import { getFullImagePath } from "@/utils/get-full-image-path";

/**
 * @param {{search: string; length: number; page: number}} param0 
 */
export const fetchListProduk = async ({
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

export const fetchDetailProduk = async id => {
	const parsedId = parseInt(id);
	
	const { data } = await api.get(`/produk/${parsedId}`);

	 data.gambar = getFullImagePath( data.gambar);

	return  data
}

export const getPinnedProduk = async () => {
	const { data } = await api.get("/produk/pin");

  return data.map(item => ({ ...item, gambar: getFullImagePath(item.gambar) }));
}

export const getTags = async () => {
	const { data } = await api.get("/produk/tags");

	return data
}