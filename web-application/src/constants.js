export const WA_POSYANDU = '628129084810'

export const MENU_ITEMS = [
	{ text: "Home", route: "/" },
	{ text: "Tentang", route: "/tentang" },
	{ 
		text: "Layanan", 
		childrens: [
			{ text: "Screening Balita", route: "/layanan/screening-balita" },
			{ text: "Screening Remaja", route: "/layanan/screening-remaja" },
			{ text: "Resliting", route: "/layanan/remaja-peduli-stunting" },
			{ text: "SiKambing", route: "/layanan/si-kambing" },
		], 
	},
	{ text: "Edukasi", route: "/edukasi" },
	{ text: "Berita", route: "/berita-acara" },
]

export const FOOTER_MENU_ITEMS = [
	{
		title: "Menu",
		items: [
			{ text: "Home", route: "/" },
			{ text: "Edukasi", route: "/edukasi" },
			{ text: "Berita", route: "/berita-acara" },
			{ text: "Tentang", route: "/tentang" },
		],
	},
	{
		title: "Layanan",
		items: [
			{ text: "Screening Balita", route: "/layanan/screening-balita" },
			{ text: "Screening Remaja", route: "/layanan/screening-remaja" },
			{ text: "Resliting", route: "/layanan/remaja-peduli-stunting" },
			{ text: "SiKambing", route: "/layanan/si-kambing" },
		],
	},
]


export const DEFAULT_POSYANDU_DATA = {
  nama_posyandu: '',
  kota: '',
  kecamatan: '',
  kelurahan: '',
  rt_rw: '',
  penyampaian_ketua: '',
  gambar_gedung: '',
  visi: '',
  misi: '',
  foto_profile_ketua: '',
  jabatan_ketua: "",
  nama_lengkap_ketua: "",
}

export const DEFAULT_TANTANGAN = {
	judul: "",
	overview: "",
	deskripsi: "",
	gambar: null,
	tanggal_mulai: null,
	tanggal_selesai: null,
}


export const DEFAULT_PRODUK = {
	nomor_telepon: '',
	nama: '',
	deskripsi: ``,
	overview: '',
	tags: [],
	harga: 0,
	gambar: '',
	sedang_dijual: false,
	pin: false,
}