import { api } from "@/lib/api";
import { getFullImagePath } from "@/utils/get-full-image-path";

export const fetchDataBeritaAcara = async ({
	page = 1,
	search = "",
	lengthPerPage = 6,
}) => {
	const { data } = await api.get(
		`/berita`,
		{
			params: { start: page, length: lengthPerPage, search },
		},
	);

	const listDataBeritaAcara = data.berita.map(item => ({ ...item, gambar: getFullImagePath(item.gambar) }));
	const pages = Math.ceil(data.jumlah_data / lengthPerPage);

	return { listDataBeritaAcara, pages };
}

