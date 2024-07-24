/** @type { import("vue-router").RouteRecordRaw } */
export const adminResletingRoutes = {
	path: "resleting",
	children: [
		{
			path: "tantangan",
			component: () => import('../../../pages/admin-resleting/tantangan-page.vue'),
		},
		{
			path: "tantangan/:id",
			children: [
				{
					path: "",
					component: () => import('../../../pages/admin-resleting/detail-tantangan.page.vue'),
				},
			],
		},
	],
}