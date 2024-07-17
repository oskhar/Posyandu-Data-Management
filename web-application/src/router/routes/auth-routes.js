import { requireAdmin } from "../middlewares";

/** @type { import("vue-router").RouteRecordRaw } */
export const authRoutes = {
	path: "/",
	beforeEnter: requireAdmin,
	component: () => import("../../layouts/blank-layout.vue"),
	children: [
		{
			path: "login",
			component: () => import("../../pages/authentications/login-page.vue"),
		},
		{
			path: "register",
			component: () => import("../../pages/authentications/register-page.vue"),
		},
	],
}