import { getFullImagePath } from "@/utils/get-full-image-path";
import { useProdukStore } from "@/utils/kambing-fake-store";

export const fetchProdukPreviews = async () => {
  const produkStore = useProdukStore();
  
	return new Promise(resolve => {
		const produk = produkStore.searchProduk({ tags: [], search: "", page: 1, length: 3 })

		produk.listProduk = produk.listProduk.map(item => ({ ...item, gambar: getFullImagePath(item.gambar) }))

		setTimeout(() => resolve(produk), 1000);
	})
};
