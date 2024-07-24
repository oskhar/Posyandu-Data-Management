import { updateSiBinggoSiteTitle } from "@/router/middlewares/si-binggo-middleware";

/** @type { import("vue-router").RouteRecordRaw[] } */
export const guestSiBinggoRoutes = [
	{ 
		path: "si-binggo", 
		beforeEnter: updateSiBinggoSiteTitle,
		children: [
			{ 
				path: "",
				component: () => import("../../../pages/guest-si-binggo-landing-page/si-binggo-landing-page.vue"),
			},
			{
				path: "produk/cari",
				component: () => import("../../../pages/guest-si-binggo-pages/si-binggo-search-page.vue"),
			},
			{
				path: "produk/:id",
				component: () => import("../../../pages/guest-si-binggo-pages/si-binggo-detail-page.vue"),
			},
		],
	},

]
