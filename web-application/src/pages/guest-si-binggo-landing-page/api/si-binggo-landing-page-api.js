import { api } from "@/lib/api";
import { getFullImagePath } from "@/utils/get-full-image-path";

export const fetchProdukPreviews = async () => {
  const { data } = await api.get("/produk", {
		params: { length: 3, page: 1, tags: [], sort: "terbaru" },
	});


	return data.data.map(item => ({ ...item, gambar: getFullImagePath(item.gambar) }));
};
