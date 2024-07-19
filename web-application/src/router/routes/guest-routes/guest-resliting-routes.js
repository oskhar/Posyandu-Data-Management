
/** @type { import("vue-router").RouteRecordRaw[] } */
export const guestReslitingRoutes = [
	{ 
		path: "remaja-peduli-stunting", 
		component: () => import("../../../pages/resliting-landing-page/resliting-landing-page.vue"), 	
	},
	{
		path: "remaja-peduli-stunting/tantangan",
		component: () => import("../../../pages/resliting-tantangan-page/resliting-tantangan-page.vue"),
	},
	{
		path: "remaja-peduli-stunting/tantangan/:id",
		component: () => import("../../../pages/resliting-tantangan-page/detail-resliting-tantangan-page.vue"),
	},
]
