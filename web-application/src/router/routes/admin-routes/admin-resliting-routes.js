/** @type { import("vue-router").RouteRecordRaw } */
export const adminReslitingRoutes = {
	path: "remaja-peduli-stunting",
	children: [
		{
			path: "tantangan",
			component: () => import('../../../pages/resliting-admin/tantangan-page.vue'),
		},
		{
			path: "tantangan/:id",
			children: [
				{
					path: "",
					component: () => import('../../../pages/resliting-admin/detail-tantangan.page.vue'),
				},
				{
					path: "submissions",
					component: () => import('../../../pages/resliting-admin/submission-tantangan-page.vue'),
				},
			],
		},
	],
}