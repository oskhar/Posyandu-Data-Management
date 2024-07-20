import z from "zod";

export const produkValidator = z.object({
	nomor_telepon: z.string().trim().min(1, "Nomor telepon tidak boleh kosong!"),
	nama: z.string().trim().min(1, "Nama tidak boleh kosong!"),
	deskripsi: z.string().trim().min(1, "Deskripsi tidak boleh kosong!"),
	overview: z.string().trim().min(1, "Overview tidak boleh kosong!"),
	tags: z.array(z.string().trim().min(1, "tag tidak boleh kosong!")).min(1, "Tag tidak boleh kosong!"),
	harga: z.number().gt(1, "Harga tidak boleh nol!"),
	gambar: z.string().trim().min(1, "Gambar tidak boleh kosong!"),
	sedang_dijual: z.boolean({ message: "Status sedang dijual harus diisi!" }),
	pin: z.boolean({ message: "Status apakah produk di pin harus diisi!" }),
})

