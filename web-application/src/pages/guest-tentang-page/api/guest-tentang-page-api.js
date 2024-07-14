import { api } from "@/lib/api";

export const fetchDataPosyanduMelati = async () => {
	const { data } = await api.get(`/posyandu`);

	return data;
}

export const fetchStrukturKepengurusan = async () => { 
	const { data } = await api.get(
		`/struktur-admin`,
	);

	return data;
}