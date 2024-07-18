import { requireUserLogin } from "@/router/middlewares";
import { guestReslitingRoutes } from "./guest-resliting-routes";
import { guestSiKambingRoutes } from "./guest-sikambing-routes";

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
			path: "/account-settings",
			beforeEnter: requireUserLogin,
			component: () => import("../../../pages/guest-account-settings-page/guest-account-settings-page.vue"),
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
			children: [...guestReslitingRoutes, ...guestSiKambingRoutes],
		},
	],
}