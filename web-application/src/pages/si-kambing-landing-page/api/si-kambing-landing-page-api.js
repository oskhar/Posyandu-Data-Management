import { useProdukStore } from "@/utils/kambing-fake-store";

export const fetchProdukPreviews = async () => {
  const productStore = useProdukStore();
  
	return productStore.searchProduk("").slice(0, 3);
};
