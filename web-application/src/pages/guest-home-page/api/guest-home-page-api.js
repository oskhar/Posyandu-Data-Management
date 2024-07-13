import { api } from "@/lib/api";
import { getFullImagePath } from "@/utils/get-full-image-path";

export const fetchJumlahEdukasi = async () => {
	const { data } = await api.get(`/edukasi?start=0&length=0`);

	return data.jumlah_data;
}

export const fetchJumlahBerita = async () => {
	const { data } = await api.get(`/berita?start=0&length=0`);

	return data.jumlah_data;
}

export const fetchJumlahGambar = async () => {
	const { data } = await api.get(`/gambar?start=0&length=0`);

	return data.jumlah_data;
}

export const fetchJumlahBayi = async () => {
	const { data } = await api.get(`/jumlah-bayi`);

	return data;
}

export const fetchDataPosyanduMelati = async () => {
	const { data } = await api.get(`/posyandu`);

	return data;
}

export const fetchPreviewEdukasi = async () => {
	const { data } = await api.get(
		`/edukasi`,
		{	params: { start: 1, length: 3 } },
	);

	return data.edukasi.map(item => ({ ...item, gambar: getFullImagePath(item.gambar) }));
}

export const fetchPreviewBeritaAcara = async () => {
	const { data } = await api.get(
		`/berita`,
		{	params: { start: 1, length: 3 } },
	);

	return data.berita.map(item => ({ ...item, gambar: getFullImagePath(item.gambar) }));
}

export const fetchGallery = async page => {
	const dataPerPage = 8;

	const { data } = await api.get(
		`/gambar`,
		{	params: { start: page, length: dataPerPage } },
	);

	const pages = Math.ceil(data.jumlah_data / dataPerPage);

	return {
		pictures: data.gambar.map(item => ({ ...item, gambar: getFullImagePath(item.gambar) })),
		pages,
	};
}