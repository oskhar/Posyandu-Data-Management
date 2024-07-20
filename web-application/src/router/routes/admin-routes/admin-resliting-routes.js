/** @type { import("vue-router").RouteRecordRaw } */
export const adminReslitingRoutes = {
	path: "remaja-peduli-stunting",
	children: [
		{
			path: "tantangan",
			component: () => import('../../../pages/admin-resliting/tantangan-page.vue'),
		},
		{
			path: "tantangan/:id",
			children: [
				{
					path: "",
					component: () => import('../../../pages/admin-resliting/detail-tantangan.page.vue'),
				},
			],
		},
	],
}