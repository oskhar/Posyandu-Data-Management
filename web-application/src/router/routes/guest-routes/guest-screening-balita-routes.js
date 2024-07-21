import { updateScreeningBalitaSiteTitle } from "@/router/middlewares/screening-middleware";

/** @type { import("vue-router").RouteRecordRaw[] } */
export const guestScreeningBalitaRoutes = [
	{ 
		path: "screening-balita", 
		beforeEnter: updateScreeningBalitaSiteTitle,
		component: () => import("../../../pages/guest-screening-balita-page/guest-screening-balita-page.vue"), 	
	},
	{ 
		path: "screening-balita/:idBalita", 
		beforeEnter: updateScreeningBalitaSiteTitle,
		component: () => import("../../../pages/guest-screening-balita-page/guest-detail-screening-balita-page.vue"), 	
	},
		
]
