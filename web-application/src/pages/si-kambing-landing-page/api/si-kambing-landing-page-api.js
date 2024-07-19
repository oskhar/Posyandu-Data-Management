import { useProdukStore } from "@/utils/kambing-fake-store";

export const fetchProdukPreviews = async () => {
  const productStore = useProdukStore();

  
	return productStore.searchProduk({ search: "", length: 3, page: 1, tags: [] });
};
