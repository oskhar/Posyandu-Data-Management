import { updateResletingSiteTitle, updateTantanganResletingSiteTitle } from "@/router/middlewares";

/** @type { import("vue-router").RouteRecordRaw[] } */
export const guestResletingRoutes = [
	{ 
		path: "remaja-peduli-stunting", 
		beforeEnter: updateResletingSiteTitle,
		component: () => import("../../../pages/guest-resleting-landing-page/resleting-landing-page.vue"), 	
	},
	{
		path: "remaja-peduli-stunting/tantangan",
		beforeEnter: updateTantanganResletingSiteTitle,
		component: () => import("../../../pages/guest-resleting-tantangan-page/resleting-tantangan-page.vue"),
	},
	{
		path: "remaja-peduli-stunting/tantangan/:id",
		beforeEnter: updateTantanganResletingSiteTitle,
		component: () => import("../../../pages/guest-resleting-tantangan-page/detail-resleting-tantangan-page.vue"),
	},
]