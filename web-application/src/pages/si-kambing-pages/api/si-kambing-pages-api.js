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
		setTimeout(() => resolve(produkStore.searchProduk({ tags, search, page, length: lengthPerPage })), 1000);
	})
}

export const fetchDetailProduk = async id => {
	const produkStore = useProdukStore();

	return new Promise(resolve => resolve(produkStore.readProduk(id)))
}