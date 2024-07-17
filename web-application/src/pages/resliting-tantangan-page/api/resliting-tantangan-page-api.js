import { getFullImagePath } from "@/utils/get-full-image-path"

export const fetchDataTantangan = async ({
	page = 1,
	search = "",
	lengthPerPage = 6,
}) => {
	// TODO: Implement fetchTantanganPreviews
	const listTantangan = Array.from({ length: lengthPerPage }, () => (
    {
      id: 1,
      gambar: "/images/upload/default.png",
      judul: crypto.randomUUID(),
      deskripsi: "Sebuah tantangan kebugaran yang bertujuan untuk meningkatkan kesehatan dan kebugaran fisik peserta dalam waktu satu bulan.",
      tanggal_mulai: "2024-07-01",
      tanggal_selesai: "2024-07-31",
      created_at: "2024-06-01T10:00:00Z",
    }
  )) 


	return new Promise(resolve => {
		setTimeout(() => resolve(
			{
				listDataTantangan: listTantangan
					.map(item => ({ ...item, gambar: getFullImagePath(item.gambar) }))
					.filter(item => item.judul.toLowerCase().includes(search.toLowerCase())),
				pages: 10,
			},
		), 500)
	})
}

