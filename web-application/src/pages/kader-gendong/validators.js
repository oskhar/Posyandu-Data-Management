import z from "zod"

export const ditugaskanValidator = z.object({
	nama: z.string().trim().min(1, "Nama yang ditugaskan tidak boleh kosong"),
	jabatan: z.string().trim().min(1, "Jabatan yang ditugaskan tidak boleh kosong"),
	alamat: z.string().trim().min(1, "Alamat yang ditugaskan tidak boleh kosong"),
})

export const suratTugasValidator = z.object({
	"penanda_tangan": z.string({
    invalid_type_error: "Penanda tangan tidak valid",
    required_error: "Penanda tangan tidak boleh kosong",
  }).trim().min(1, "Penanda tangan tidak boleh kosong"),
  "tanggal_surat": z.string({
    required_error: "Tanggal surat tidak boleh kosong",
  }).trim().datetime("Tanggal surat tidak valid"),
  "nomor": z.string().trim().min(1, "Nomor surat tidak boleh kosong"),
  "kalimat_pembuka": z.string().trim().min(1, "Kalimat pembuka tidak boleh kosong"),
  "ditugaskan": z.array(ditugaskanValidator, "Yang ditugaskan tidak valid").min(1, "Yang ditugaskan tidak boleh kosong"),
  "isi_surat": z.string().trim().min(1, "Isi surat tidak boleh kosong"),
  "kalimat_penutup": z.string().trim().min(1, "Kalimat penutup tidak boleh kosong"),
})