
/** @type { import("vue-router").RouteRecordRaw[] } */
export const reslitingRoutes = [
	{ 
		path: "remaja-peduli-stunting", 
		component: () => import("../../../pages/resliting-landing-page/resliting-landing-page.vue"), 	
	},
	{
		path: "remaja-peduli-stunting/tantangan",
		component: () => import("../../../pages/resliting-tantangan-page/resliting-tantangan-page.vue"),
	},
]
