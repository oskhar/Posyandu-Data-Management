import { getFullImagePath } from "@/utils/get-full-image-path";

export const fetchTantanganPreviews = async () => {
	// TODO: Implement fetchTantanganPreviews
	const listTantangan = [{
		id: 1,
		gambar: "/images/upload/default.png",
		judul: "Tantangan Kebugaran Bulanan",
		deskripsi: "Sebuah tantangan kebugaran yang bertujuan untuk meningkatkan kesehatan dan kebugaran fisik peserta dalam waktu satu bulan.",
		tanggal_mulai: "2024-07-01",
		tanggal_selesai: "2024-07-31",
		created_at: "2024-06-01T10:00:00Z",
	}, {
		id: 2,
		gambar: "/images/upload/default.png",
		judul: "Tantangan Membaca 30 Buku",
		deskripsi: "Tantangan membaca yang mengajak peserta untuk membaca 30 buku dalam setahun.",
		tanggal_mulai: "2024-01-01",
		tanggal_selesai: "2024-12-31",
		created_at: "2023-12-01T08:30:00Z",
	}, {
		id: 3,
		gambar: "/images/upload/default.png",
		judul: "Tantangan Menulis Novel",
		deskripsi: "Tantangan menulis novel yang mendorong penulis untuk menyelesaikan novel dalam tiga bulan.",
		tanggal_mulai: "2024-09-01",
		tanggal_selesai: "2024-11-30",
		created_at: "2024-08-01T14:45:00Z",
	}];


	return new Promise(resolve => {
		setTimeout(() => resolve(
			listTantangan.map(item => ({ ...item, gambar: getFullImagePath(item.gambar) })),
		), 2000)
	})
}
