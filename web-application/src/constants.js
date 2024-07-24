export const WA_POSYANDU = '628129084810'

export const MENU_ITEMS = [
	{ text: "Home", route: "/" },
	{ text: "Tentang", route: "/tentang" },
	{ 
		text: "Layanan", 
		childrens: [
			{ text: "Screening Balita", route: "/layanan/screening-balita" },
			{ text: "Screening Remaja", route: "/layanan/screening-remaja" },
			{ text: "Resleting", route: "/layanan/remaja-peduli-stunting" },
			{ text: "SiBinggo", route: "/layanan/si-binggo" },
		], 
	},
	{ text: "Edukasi", route: "/edukasi" },
	{ text: "Events", route: "/events" },
]

export const FOOTER_MENU_ITEMS = [
	{
		title: "Menu",
		items: [
			{ text: "Home", route: "/" },
			{ text: "Edukasi", route: "/edukasi" },
			{ text: "Events", route: "/events" },
			{ text: "Tentang", route: "/tentang" },
		],
	},
	{
		title: "Layanan",
		items: [
			{ text: "Screening Balita", route: "/layanan/screening-balita" },
			{ text: "Screening Remaja", route: "/layanan/screening-remaja" },
			{ text: "Resleting", route: "/layanan/remaja-peduli-stunting" },
			{ text: "SiBinggo", route: "/layanan/si-binggo" },
		],
	},
]

export const ITEM_BULAN = [
  { value: 1, title: 'Januari' },
  { value: 2, title: 'Februari' },
  { value: 3, title: 'Maret' },
  { value: 4, title: 'April' },
  { value: 5, title: 'Mei' },
  { value: 6, title: 'Juni' },
  { value: 7, title: 'Juli' },
  { value: 8, title: 'Agustus' },
  { value: 9, title: 'September' },
  { value: 10, title: 'Oktober' },
  { value: 11, title: 'November' },
  { value: 12, title: 'Desember' },
];

export const DEFAULT_SURAT = {
	penanda_tangan: "",
	tanggal_surat: null,
	jabatan_penanda_tangan: "",
	nomor: "",
	kalimat_pembuka: '',
	ditugaskan: [],
	isi_surat: '',
	kalimat_penutup: '',
}


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