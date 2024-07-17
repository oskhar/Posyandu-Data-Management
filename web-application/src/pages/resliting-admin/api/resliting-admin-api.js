import { getFullImagePath } from "@/utils/get-full-image-path";

/**
 * @param {{search: string; length: number; page: number}} param0 
 * @returns {import("./types").TantanganResponse}
 */
export const getListTantangan = async ({
	page = 1,
	search = "",
	lengthPerPage = 6,
}) => {
	// TODO: Implement getListTantangan
	return {
    links: new Array(10).fill(""),
    current_page: page,
    data: Array.from({ length: lengthPerPage }, () => (
      {
        id: 1,
        gambar: getFullImagePath("/images/upload/default.png"),
        judul: crypto.randomUUID(),
        deskripsi: "Sebuah tantangan kebugaran yang bertujuan untuk meningkatkan kesehatan dan kebugaran fisik peserta dalam waktu satu bulan.",
        tanggal_mulai: "2024-07-01",
        tanggal_selesai: "2024-07-31",
        created_at: "2024-06-01T10:00:00Z",
      }
    )),
  }
}


export const getSingleTantangan = async id => {
	// TODO: Implement getSingleTantangan
  return {
    id: 1,
    gambar: getFullImagePath("/images/upload/default.png"),
    judul: crypto.randomUUID(),
    deskripsi: "Sebuah tantangan kebugaran yang bertujuan untuk meningkatkan kesehatan dan kebugaran fisik peserta dalam waktu satu bulan.",
    tanggal_mulai: "2024-07-01",
    tanggal_selesai: "2024-07-31",
    created_at: "2024-06-01T10:00:00Z",
  }
}

/**
 * @param {import("./types").CreateTantangan} tantangan 
 */
export const createTantangan = async tantangan => {
	// TODO: Implement createTantangan
  console.log(tantangan);


  return {
    message: "Tantangan berhasil dibuat",
  }
}


/**
 * @param {string} id 
 * @param {import("./types").CreateTantangan} tantangan 
 */
export const editListTantangan = async (id, tantangan) => {
	// TODO: Implement createListTantangan
  console.log(tantangan);
}

/**
 * @param {string} id 
 */
export const deleteTantangan = async id => {
  // TODO: Implement createListTantangan
  console.log(id);

  return {
    message: "Tantangan berhasil dihapus",
  }
}