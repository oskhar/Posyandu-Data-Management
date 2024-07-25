
export const MENU_ITEMS = [
	{ text: "Home", route: "/" },
	{ text: "Tentang", route: "/tentang" },
	{ 
		text: "Layanan", 
		childrens: [
			{ text: "Screening Balita", route: "/layanan/screening-balita" },
			{ text: "Screening Remaja", route: "/layanan/screening-remaja" },
			{ text: "Resleting", route: "/layanan/resleting" },
			{ text: "SiBinggo", route: "/layanan/si-binggo" },
		], 
	},
	{ text: "Edukasi", route: "/edukasi" },
	{ text: "Events", route: "/events" },
	{ text: "Kontak", route: "#kontak" },
]
