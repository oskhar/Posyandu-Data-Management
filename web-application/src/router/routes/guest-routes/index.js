import { requireUserLogin } from "@/router/middlewares";
import { reslitingRoutes } from "./resliting-routes";

/** @type { import("vue-router").RouteRecordRaw } */
export const guestRoutes = {
	path: "/",
	component: () => import("../../../layouts/guest/guest-layout.vue"),
	children: [
		{
			path: "",
			component: () => import("../../../pages/guest-home-page/guest-home-page.vue"),
		},
		{
			path: "edukasi",
			component: () => import("../../../pages/guest-edukasi-page/guest-edukasi-page.vue"),
		},
		{
			path: "edukasi/:id",
			component: () => import("../../../pages/guest-edukasi-page/detail-guest-edukasi-page.vue"),
		},
		{
			path: "berita-acara",
			component: () => import("../../../pages/guest-berita-acara-page/guest-berita-acara-page.vue"),
		},
		{
			path: "berita-acara/:id",
			component: () => import("../../../pages/guest-berita-acara-page/detail-guest-berita-acara-page.vue"),
		},
		{
			path: "tentang",
			component: () => import("../../../pages/guest-tentang-page/guest-tentang-page.vue"),
		},
		{
			path: "layanan",
			children: [...reslitingRoutes],
		},
	],

	path: "/",
	beforeEnter: requireUserLogin,
	component: () => import("../../../layouts/guest/guest-layout.vue"),
	children: [
		{
			path: "/account-settings",
			component: () => import("../../../pages/guest-account-settings-page/guest-account-settings-page.vue"),
		},
	],
}