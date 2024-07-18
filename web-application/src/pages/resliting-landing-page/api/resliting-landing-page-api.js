import { api } from "@/lib/api";
import { getFullImagePath } from "@/utils/get-full-image-path";

export const fetchTantanganPreviews = async () => {
	const { data } = await api.get("/resleting/tantangan", {
		params: { page: 1, length: 3 },
	})
	
	/** @type {import("./types").TantanganPreviewResponse} */
	const dataResponse = data;

	return dataResponse.data.map(item => ({ ...item, gambar: getFullImagePath(item.gambar) }));
}
