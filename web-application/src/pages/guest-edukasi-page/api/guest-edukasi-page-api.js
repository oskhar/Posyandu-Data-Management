import { api } from "@/lib/api";
import { getFullImagePath } from "@/utils/get-full-image-path";

export const fetchDataEdukasi = async ({
	page = 1,
	search = "",
	lengthPerPage = 6,
}) => {
	const { data } = await api.get(
		`/edukasi`,
		{
			params: { start: page, length: lengthPerPage, search },
		},
	);

	const listDataEdukasi = data.edukasi.map(item => ({ ...item, gambar: getFullImagePath(item.gambar) }));
	const pages = Math.ceil(data.jumlah_data / lengthPerPage);

	return { listDataEdukasi, pages };
}

