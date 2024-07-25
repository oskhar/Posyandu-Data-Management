import z from "zod";

export const tantanganValidator = z.object({
 judul: z.string().trim().min(1, "Judul tidak boleh kosong!"),
 gambar: z.string().trim().min(1, "Gambar tidak boleh kosong!"),
 overview: z.string().trim().min(1, "Overview tidak boleh kosong!"),
 deskripsi: z.string().trim().min(1, "Deskripsi tidak boleh kosong!"),
 tanggal_mulai: z.string().trim().min(1, "Tanggal mulai tidak boleh kosong!"),
 tanggal_selesai: z.string().trim().min(1, "Tanggal selesai tidak boleh kosong!"),
})