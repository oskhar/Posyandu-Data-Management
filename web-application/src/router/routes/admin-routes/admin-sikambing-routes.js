
/** @type { import("vue-router").RouteRecordRaw[] } */
export const adminSiKambingRoutes = [
	{ 
		path: "si-kambing", 
		children: [
			{ 
				path: "",
				component: () => import("../../../pages/resliting-landing-page/resliting-landing-page.vue"),
			},
			{
				path: "produk/:id",
				component: () => import("../../../pages/resliting-tantangan-page/resliting-tantangan-page.vue"),
			},
		],
	},

]
