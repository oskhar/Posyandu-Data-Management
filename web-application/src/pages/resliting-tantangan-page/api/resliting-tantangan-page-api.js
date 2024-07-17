import { getFullImagePath } from "@/utils/get-full-image-path"

export const fetchDataTantangan = async ({
	page = 1,
	search = "",
	lengthPerPage = 6,
}) => {
	// TODO: Implement fetchDataTantangan
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

export const fetchDataFollowedTantangan = async ({
	page = 1,
	search = "",
	lengthPerPage = 6,
}) => {
	// TODO: Implement fetchDataFollowedTantangan
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
				listDataFollowedTantangan: listTantangan
					.map(item => ({ ...item, gambar: getFullImagePath(item.gambar) }))
					.filter(item => item.judul.toLowerCase().includes(search.toLowerCase())),
				pages: 10,
			},
		), 500)
	})
}

export const fetchDataDetailTantangan = async id => {
	const detailTantangan = {
    id: 1,
    gambar: "/images/upload/default.png",
    judul: "Tantangan Kebugaran Bulanan",
    overview: "Sebuah tantangan kebugaran yang bertujuan untuk meningkatkan kesehatan dan kebugaran fisik peserta dalam waktu satu bulan",
    deskripsi: `<h2>Sebuah tantangan kebugaran yang bertujuan untuk meningkatkan kesehatan dan kebugaran fisik peserta dalam waktu satu bulan.</h2><p>Tantangan Kebugaran Bulanan adalah sebuah program yang dirancang untuk mendorong individu dalam meningkatkan kondisi fisik mereka selama periode satu bulan. Dalam tantangan ini, peserta akan mengikuti berbagai aktivitas dan latihan kebugaran yang dirancang untuk meningkatkan stamina, kekuatan, dan fleksibilitas.</p><p>Program ini dimulai pada tanggal 1 Juli 2024 dan berakhir pada tanggal 31 Juli 2024. Setiap peserta akan diberikan panduan latihan harian serta tips nutrisi untuk memastikan mereka mendapatkan hasil yang maksimal. Tidak hanya itu, peserta juga akan bergabung dalam komunitas online untuk saling mendukung dan memotivasi satu sama lain.</p><p>Selain meningkatkan kesehatan fisik, tantangan ini juga bertujuan untuk membangun kebiasaan hidup sehat yang berkelanjutan. Dengan mengikuti program ini, peserta diharapkan dapat melanjutkan gaya hidup aktif dan sehat bahkan setelah tantangan selesai.</p><p>Jadi, apakah Anda siap untuk menerima Tantangan Kebugaran Bulanan dan memulai perjalanan menuju tubuh yang lebih sehat dan bugar? Daftarkan diri Anda sekarang dan jadilah bagian dari komunitas kebugaran yang penuh semangat!</p>`,
    tanggal_mulai: "2024-07-01",
    tanggal_selesai: "2024-07-31",
    created_at: "2024-06-01T10:00:00Z",
};


	return new Promise(resolve => {
		setTimeout(() => resolve(
			{ ...detailTantangan, gambar: getFullImagePath(detailTantangan.gambar) },
		), 500)
	})
}

export const sendSubmissionTantangan = async ({
	file = null, link = null, 
}) => {
	// TODO: Implement sendSubmissionTantangan

	return new Promise(resolve => {
		setTimeout(() => {
			console.log("sendSubmissionTantangan", { file, link })
			resolve()
		}, 1000)
	})
}