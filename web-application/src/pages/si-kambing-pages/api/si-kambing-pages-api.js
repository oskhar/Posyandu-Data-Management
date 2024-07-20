import { getFullImagePath } from "@/utils/get-full-image-path";
import { useProdukStore } from "@/utils/kambing-fake-store";

/**
 * @param {{search: string; length: number; page: number}} param0 
 */
export const fetchListProduk = async ({
	page = 1,
	search = "",
	lengthPerPage = 6,
	tags = [],
}) => {
	const produkStore = useProdukStore();

	return new Promise(resolve => {
		const produk = produkStore.searchProduk({ tags, search, page, length: lengthPerPage })

		produk.listProduk = produk.listProduk.map(item => ({ ...item, gambar: getFullImagePath(item.gambar) }))

		setTimeout(() => resolve(produk), 1000);
	})
}

export const fetchDetailProduk = async id => {
	const parsedId = parseInt(id);
	const produkStore = useProdukStore();

	return new Promise(resolve => {
		const produk = produkStore.readProduk(parsedId)

		produk.gambar = getFullImagePath(produk.gambar)

		setTimeout(() => resolve(produk), 1000);	
	})
}