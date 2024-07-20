
/** @type { import("vue-router").RouteRecordRaw[] } */
export const guestScreeningBalitaRoutes = [
	{ 
		path: "screening-balita", 
		component: () => import("../../../pages/guest-screening-balita-page/guest-screening-balita-page.vue"), 	
	},
	{ 
		path: "screening-balita/:idBalita", 
		component: () => import("../../../pages/guest-screening-balita-page/guest-detail-screening-balita-page.vue"), 	
	},
		
]
