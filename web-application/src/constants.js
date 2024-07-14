export const MENU_ITEMS = [
	{ text: "Home", route: "/" },
	{ text: "Tentang", route: "/tentang-guest" },
	{ 
		text: "Layanan", 
		childrens: [
			{ text: "Screening Balita", route: "/layanan/screening-balita" },
			{ text: "Screening Remaja", route: "/layanan/screening-remaja" },
			{ text: "Resliting", route: "/layanan/remaja-peduling-stunting" },
			{ text: "SiKambing", route: "/layanan/sikambing" },
		], 
	},
	{ text: "Edukasi", route: "/selengkapnya-card-edukasi" },
	{ text: "Berita", route: "/selengkapnya-card-beritaacara" },
]

export const FOOTER_MENU_ITEMS = [
	{
		title: "Menu",
		items: [
			{ text: "Home", route: "/" },
			{ text: "Edukasi", route: "/selengkapnya-card-edukasi" },
			{ text: "Berita", route: "/selengkapnya-card-beritaacara" },
			{ text: "Tentang", route: "/tentang-guest" },
		],
	},
	{
		title: "Layanan",
		items: [
			{ text: "Screening Balita", route: "/layanan/screening-balita" },
			{ text: "Screening Remaja", route: "/layanan/screening-remaja" },
			{ text: "Resliting", route: "/layanan/remaja-peduling-stunting" },
			{ text: "SiKambing", route: "/layanan/sikambing" },
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