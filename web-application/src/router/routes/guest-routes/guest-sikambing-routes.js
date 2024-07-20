
/** @type { import("vue-router").RouteRecordRaw[] } */
export const guestSiKambingRoutes = [
	{ 
		path: "si-kambing", 
		children: [
			{ 
				path: "",
				component: () => import("../../../pages/guest-si-kambing-landing-page/si-kambing-landing-page.vue"),
			},
			{
				path: "produk/cari",
				component: () => import("../../../pages/si-kambing-pages/si-kambing-search-page.vue"),
			},
			{
				path: "produk/:id",
				component: () => import("../../../pages/si-kambing-pages/si-kambing-detail-page.vue"),
			},
		],
	},

]
