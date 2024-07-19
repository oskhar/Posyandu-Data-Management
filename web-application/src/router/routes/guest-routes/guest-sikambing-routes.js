
/** @type { import("vue-router").RouteRecordRaw[] } */
export const guestSiKambingRoutes = [
	{ 
		path: "si-kambing", 
		children: [
			{ 
				path: "",
				component: () => import("../../../pages/si-kambing-landing-page/si-kambing-landing-page.vue"),
			},
			{
				path: "produk",
				component: () => import("../../../pages/resliting-tantangan-page/resliting-tantangan-page.vue"),
			},
			{
				path: "produk/cari",
				component: () => import("../../../pages/resliting-tantangan-page/resliting-tantangan-page.vue"),
			},
			{
				path: "produk/:id",
				component: () => import("../../../pages/resliting-tantangan-page/resliting-tantangan-page.vue"),
			},
		],
	},

]
