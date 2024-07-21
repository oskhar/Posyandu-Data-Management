import { updateReslitingSiteTitle, updateTantanganReslitingSiteTitle } from "@/router/middlewares";

/** @type { import("vue-router").RouteRecordRaw[] } */
export const guestReslitingRoutes = [
	{ 
		path: "remaja-peduli-stunting", 
		beforeEnter: updateReslitingSiteTitle,
		component: () => import("../../../pages/guest-resliting-landing-page/resliting-landing-page.vue"), 	
	},
	{
		path: "remaja-peduli-stunting/tantangan",
		beforeEnter: updateTantanganReslitingSiteTitle,
		component: () => import("../../../pages/guest-resliting-tantangan-page/resliting-tantangan-page.vue"),
	},
	{
		path: "remaja-peduli-stunting/tantangan/:id",
		beforeEnter: updateTantanganReslitingSiteTitle,
		component: () => import("../../../pages/guest-resliting-tantangan-page/detail-resliting-tantangan-page.vue"),
	},
]
